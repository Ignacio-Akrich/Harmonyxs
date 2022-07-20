<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Ad;
use Inertia\Inertia;
use App\Models\User;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('Artista')){
        $user = Auth::user()->id;
        $anuncios = Ad::with(['user'])->where('user_id', $user)->take(4)->orderBy('created_at', 'desc')->get();
        // $social = SocialMedia::with(['user'])->where('user_id', $user)->get();
        $artistas = User::all();
        return Inertia::render('Perfiles/Artist', [
            'artistas' => $artistas,
            'anuncios'=> $anuncios,
           /*  'socials' => $social, */
        ]);
        }else if(auth()->user()->hasRole('Banda')){
            $user = Auth::user()->id;
            $anuncios = Ad::with(['user'])->where('user_id', $user)->take(4)->orderBy('created_at', 'desc')->get();
            // $social = SocialMedia::with(['user'])->where('user_id', $user)->get();
            $bandas = User::all();
            return Inertia::render('Perfiles/Band', [
                'bandas' => $bandas,
                'anuncios'=> $anuncios,
                /* 'socials' => $social, */
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileRequest $request)
    {
        $validation = new ProfileRequest();
        $input = $request->all();

        if ($input) {
            $request->validate($validation->rules($request));
            auth()->user()->update($request->except('_method'));
        }

        $validator = Validator::make($request->all(), $validation->rules($request), $validation->messages());
        $imageName = Str::random(11).'.'.$input['profile_photo']->extension();
        $input['profile_photo'] = $request->file('profile_photo')->storeAs('imageprofile', $imageName, 'public');
        auth()->user()->update($input);
        return redirect()->route('artist');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //mostrar el perfil del cualquier usuario pasandole el id sin cambiar el usuario autentificado
        $user = User::findOrFail($id);
        return Inertia::render('Perfiles/Show', [
            'userperfil' => $user,
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Perfiles/Edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       if($user->id == auth()->user()->id){
        auth()->user()->update($request->except('_method'));
        return redirect()->route('artist');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
