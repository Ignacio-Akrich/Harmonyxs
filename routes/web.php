<?php

use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\VistaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use \App\Http\Controllers\MisAnunciosController;
use \App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
}); */

Route::get('/', [VistaController::class, 'index'])->name('home');

// Para un mayor control de las rutas, las agrupo de esta manera. La persona que navega puede ver el index
// de los anuncios, pero no puede modificarlos, así que todas deben pasar por el middleware auth menos el index.
Route::group(
    [
        'prefix' => 'anuncios',
    ],
    function () {
        Route::get('/', [AnuncioController::class, 'index'])->name('anuncios.index');
        Route::group([
            'middleware' => ['auth', 'verified'],
        ], function () {

            Route::get('/crear', [AnuncioController::class, 'create'])->name('anuncios.create');
            Route::get('/editar/{ad}', [AnuncioController::class, 'edit'])->name('anuncios.edit');
            Route::put('/{ad}', [AnuncioController::class, 'update'])->name('anuncios.update');
            Route::get('/ver/{ad}', [AnuncioController::class, 'show'])->name('anuncios.show');
            Route::post('/', [AnuncioController::class, 'store'])->name('anuncios.store');
            Route::delete('/{ad}', [AnuncioController::class, 'destroy'])->name('anuncios.destroy');
            Route::post('/show/', [AnuncioController::class, 'sendEmail'])->name('send.name');
            Route::put('ver/{ad}', [AnuncioController::class, 'updateAdImage'])->name('anuncios.updateadimage');
        });
    }
);

Route::group(
    [
        'prefix' => 'misanuncios',
    ],
    function () {
        Route::get('/', [MisAnunciosController::class, 'index'])->name('misanuncios.index');
        Route::group([
            'middleware' => ['auth', 'verified'],
        ], function () {
            Route::get('/crear', [MisAnunciosController::class, 'create'])->name('misanuncios.create');
            Route::get('/editar/{ad}', [MisAnunciosController::class, 'edit'])->name('misanuncios.edit');
            Route::put('/{ad}', [MisAnunciosController::class, 'update'])->name('misanuncios.update');
            Route::get('/show/{ad}', [MisAnunciosController::class, 'show'])->name('misanuncios.show');
            Route::post('/', [MisAnunciosController::class, 'store'])->name('misanuncios.store');
            Route::delete('/{ad}', [MisAnunciosController::class, 'destroy'])->name('misanuncios.destroy');
            Route::put('show/{ad}', [AnuncioController::class, 'updateAdImage'])->name('misanuncios.updateadimage');
        });
    }
);

Route::group(
    [
        'prefix' => 'administracion',
    ],
    function () {
        Route::group([
            'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified', 'permission:acceso administracion']
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'countAll'])->name('dashboard');
//            Route::get('/dashboard', function () {
//                return Inertia::render('Dashboard');
//            }
//            );
            Route::resource('roles', RoleController::class);
            Route::resource('usuarios', UserController::class);
        });
    }
);


Route::group(
    [
        'prefix' => 'perfil',
    ],
    function () {
        Route::group([
            'middleware' => ['auth', 'verified'],
        ], function () {
Route::get('/mi-perfil-artista', [ProfilesController::class, 'index'])->name('artist');
Route::get('/mi-perfil-banda', [ProfilesController::class, 'index'])->name('band');
Route::post('/', [ProfilesController::class, 'store'])->name('profiles.store');
Route::get('/show/{userperfil}', [ProfilesController::class, 'show'])->name('profiles.show');
Route::get('/edit/{user}', [ProfilesController::class, 'edit'])->name('profiles.edit');
Route::put('/{user}', [ProfilesController::class, 'update'])->name('profiles.update');
Route::post('/show/', [ProfilesController::class, 'sendEmail'])->name('sendprofiles.name');
        });
    }
);


