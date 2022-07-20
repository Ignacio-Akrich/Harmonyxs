<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnuncioEditRequest;
use App\Models\Ad;
use App\Models\User;
use App\Http\Requests\AnuncioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class MisAnunciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ads = Ad::query();
        $user = Auth::user()->id;
//        $ad = $ads->with(['user']);
//        $anuncios = $ad->where('user_id', $user);

        $anuncios = Ad::with(['user'])->where('user_id', $user)->orderBy('id','desc')->get();

        return Inertia::render('MisAnuncios/Index', [
            'anuncios'=> $anuncios
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        //
        return Inertia::render('MisAnuncios/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
        return Redirect::route('misanuncios.index')->with('success', 'Anuncio creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show(Ad $ad)
    {
        //
        $anuncio = Ad::query()->with('user')->get()->firstWhere('id', $ad->id);
        return Inertia::render('MisAnuncios/Show', [
            'anuncios' => $anuncio
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        return Inertia::render('MisAnuncios/Edit', [
            'anuncios' => $ad
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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

            return Redirect::route('misanuncios.index')->with('success', 'Anuncio editado correctamente');
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

            //return Redirect::route('misanuncios.show', compact($ad))->with('success', 'Foto editada correctamente');
            return back()->with('success', 'Foto editada correctamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ad $ad)
    {
        //
        if ($ad->user_id !== auth()->user()->id && !auth()->user()->hasRole('Super Admin')
            || auth()->user()->cannot('eliminar anuncio')) {
            abort(404); // or redirect, or whatever action
        } else {
            $ad->delete();
            Storage::delete('public/image/'. $ad->image);
            return Redirect::route('misanuncios.index');
        }
    }
}
