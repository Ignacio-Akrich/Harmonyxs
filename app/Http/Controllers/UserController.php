<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $user = User::query();

        $filters = request()->all(['search', 'field', 'direction', 'roles']);

        if ($filters) {
            // Hago que la query sea case-insensitive y esta solución debería servir tanto para MySQL como PSQL
            $user->where(DB::raw('lower(name)'), 'LIKE', '%'.strtolower(request('search')).'%');
            if (request()->has(['field', 'direction'])) {
                $user->orderBy(request('field'), request('direction'));
            }
        }

        $roles = $request->input('roles');

        $matchingUsers = [];

        if ($roles == null) {
            $userList = User::all();
        } else {
            $userList = User::role($roles)->get();
        }

        foreach ($userList as $users) {
            $matchingUsers[] = $users->id;
        }

        $users = $user->with(['roles'])
            ->whereIn('id', $matchingUsers)->latest()->paginate(10)->withQueryString();

        return Inertia::render('Users/Index', compact('users', 'filters'));
            // Acceder a los roles en la vista es más difícil, ya que los roles son arrays con objetos dentro
            // En la vista de anuncios le pasaba el user, que es directamente un objeto
            
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Como el usuario está creado con ayuda de Jetstream, aquí no
        // tengo por qué crear el usuario. Mirar CreateNewUser.php
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return Inertia::render('Users/Edit', [
            'usuarios' => $user,
            'roles' => $roles,
            'userRole' => $userRole,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            // 'instrumento' => 'required',
            //'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return Redirect::route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return Redirect::route('usuarios.index');
    }
}
