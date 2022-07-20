<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnuncioEditRequest;
use App\Mail\ContactMail;
use App\Http\Requests\AnuncioRequest;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AnuncioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:ver anuncio|crear anuncio|editar anuncio|eliminar anuncio', ['only' => ['index']]); // Only index es "solo tiene permisos para ejecutar el método index"
        $this->middleware('permission:crear anuncio', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar anuncio', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar anuncio', ['only' => ['destroy']]);
    }

    /**
     * Retorna la página principal de los anuncios.
     * El método with() hace 'eager loading', donde detecta la relación entre tablas de la bbdd,
     * y permite luego en la vista cargar datos de la tabla relacionada a 'ads', (la tabla 'users'),
     * es la forma más sencilla y eficiente que he encontrado de imprimir los nombres de quien publica cada anuncio.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        /* request()->validate([
            'roles' => ['in:banda,artista'],
        ]); */

        $anuncio = Ad::query();

        $filters = request()->all(['search']);

        if ($filters) {
            // Hago que la query sea case-insensitive y esta solución debería servir tanto para MySQL como PSQL
            $anuncio->where(DB::raw('lower(title)'), 'LIKE', '%'.strtolower(request('search')).'%');
        }

        $userLocationLat = $request->input('lat');
        $userLocationLng = $request->input('lng');
        $distance = $request->input('distance');
        $roles = $request->input('roles');
        $musical_genre = $request->input('music_genre');

        $matchingUsers = [];

        if ($roles == null) {
            $userList = User::all();
        } else {
            $userList = User::role($roles)->get();
        }

        if ($musical_genre != null) {
            $anuncio->where('music_genre', $musical_genre);
        }

        // Filtro búsqueda por lugar
        foreach ($userList as $users) {
            $distanceBetweenLocations = $this->getDistance($users->lat, $users->lng, $userLocationLat, $userLocationLng);
            if ($distanceBetweenLocations <= $distance) {
                $matchingUsers[] = $users->id;
            }
            elseif ($userLocationLat == null || $userLocationLng == null) {
                $matchingUsers[] = $users->id;
            }
        }

        $anuncios = $anuncio->with(['user'])
            ->whereIn('user_id', $matchingUsers)->latest()->paginate(10)->withQueryString();

        return Inertia::render('Anuncio/Index', compact('anuncios', 'filters'));
    }


    private function getDistance($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
        // Calculate the distance in degrees
        $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));

        // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
        switch($unit) {
            case 'km':
                $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
                break;
            case 'mi':
                $distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
                break;
            case 'nmi':
                $distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
        }
        return round($distance, $decimals);
    }



    /**
     * Muestra el formulario para crear un nuevo anuncio
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Anuncio/Create');
    }

    /**
     * Almacena un nuevo anuncio en el tablón de anuncios
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AnuncioRequest $request)
    {
        $validation = new AnuncioRequest();
        $validator = Validator::make($request->all(), $validation->rules($request), $validation->messages());

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $imageName = Str::random(11).'.'.$input['image']->extension();
        $input['image'] = $request->file('image')->storeAs('imagead', $imageName, 'public');

        /* if ($request->hasFile('image')) {
            $input['image'] = $request->file('image')->storeAs('imagead', $imageName, 'public');
        } */

        Ad::create($input);
        return Redirect::route('anuncios.index')->with('success', 'Anuncio creado correctamente');
//        return Inertia::render('Anuncio/Create')->with('success', 'Anuncio creado con exito');
    }

    /**
     * Para recuperar un solo anuncio, hacemos una query a la base de datos y forzamos que devuelva
     * un único resultado con firstWhere, pues de todas formas, solo hay un anuncio cuyo id coincide
     * con el id que pasamos por la url. Esto hace que sea más fácil acceder a los datos del objeto anuncio,
     * con un where normal los datos entrarían en un array con un solo objeto.
     *
     * @param object $ad
     *
     * @return \Inertia\Response
     */
    public function show(Ad $ad)
    {
        $anuncio = Ad::query()->with('user')->get()->firstWhere('id', $ad->id);
        return Inertia::render('Anuncio/Show', [
            'anuncios' => $anuncio
        ]);
    }

    /**
     * Muestra el formulario para editar un anuncio ya creado
     *
     * @param object $ad
     *
     * @return \Inertia\Response
     */
    public function edit(Ad $ad)
    {
        return Inertia::render('Anuncio/Edit', [
            'anuncios' => $ad
        ]);
    }

    /**
     * Actualiza un anuncio que se había creado anteriormente, que pasa a tener los nuevos datos.
     * No se puede modificar un anuncio existente si se cumple alguna de estas condiciones:
     * - No es el tuyo y no eres un usuario de tipo super admin
     * - Si por la razón que sea, tu usuario no tiene permiso para editar el anuncio
     * - No estás con un usuario logueado (controlado por middleware en web.php).
     *
     * @param object $ad
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AnuncioEditRequest $request, Ad $ad)
    {
        $validation = new AnuncioEditRequest();
        //$validator = Validator::make($request->all(), $validation->rules($request), $validation->messages());
        $validator = Validator::make($request->all(), $validation->rules($request), $validation->messages());

        $input = $request->all();

        if ($input) {
            $request->validate($validation->rules($request));
            $ad->update($request->except('_method'));
        }
        //'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',

        // $input['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            Storage::delete('public/image/'. $ad->image); // Elimina la imagen antigua en caso de que se vaya a subir una nueva
            $imageName = Str::random(11).'.'.$input['image']->extension();
            $input['image'] = $request->file('image')->storeAs('imagead', $imageName, 'public');
        }

        if ($ad->user_id !== auth()->user()->id && !auth()->user()->hasRole('Super Admin')
            || auth()->user()->cannot('editar anuncio')) {
            abort(404); // or redirect, or whatever action
        } else {
            $ad->update($input);

            return Redirect::route('anuncios.index')->with('success', 'Anuncio editado correctamente');
        }
    }

    public function updateAdImage(Request $request, Ad $ad)
    {
        $input = $request->all();

        if ($input) {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $ad->update($request->except('_method'));
        }

        if ($request->hasFile('image')) {
            Storage::delete('public/image/'. $ad->image); // Elimina la imagen antigua en caso de que se vaya a subir una nueva
            $imageName = Str::random(11).'.'.$input['image']->extension();
            $input['image'] = $request->file('image')->storeAs('imagead', $imageName, 'public');
        }

        if ($ad->user_id !== auth()->user()->id && !auth()->user()->hasRole('Super Admin')
            || auth()->user()->cannot('editar anuncio')) {
            abort(404); // or redirect, or whatever action
        } else {
            $ad->update($input);

            return back()->with('success', 'Foto editada correctamente');
        }
    }

    /**
     * Elimina el anuncio seleccionado.
     * No se puede eliminar un anuncio si se cumple alguna de estas condiciones:
     * - No es el tuyo y no eres un usuario de tipo super admin
     * - Si por la razón que sea, tu usuario no tiene permiso para eliminar el anuncio
     * - No estás con un usuario logueado (controlado por middleware en web.php).
     *
     * @param object $ad
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ad $ad)
    {
        if ($ad->user_id !== auth()->user()->id && !auth()->user()->hasRole('Super Admin')
            || auth()->user()->cannot('eliminar anuncio')) {
            abort(404); // or redirect, or whatever action
        } else {
            $ad->delete();
            Storage::delete('public/image/'. $ad->image);

            return Redirect::route('anuncios.index');
        }
    }

    public function sendEmail(Request $request){
            $email = $request->input('email');
        $data= [
            'title' =>$request->input('title'),
            'name' =>$request->input('name'),
            'message' =>$request->input('message'),
            'email' =>  $request->input('email')
        ];

        Mail::to($email)->send(new ContactMail($data));
        return Redirect::back()->with('success','Mensaje enviado correctamente!');
    }
}
