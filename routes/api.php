<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::name('login')->post('auth/login', 'Usuario\AuthController@login');
Route::name('logout')->get('auth/logout', 'Usuario\AuthController@logout');

Route::resource('usuarios', 'Usuario\UsuarioController', ['except' => ['create', 'edit']]);
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

Route::name('me')->get('auth/me', 'Usuario\AuthController@user');
Route::name('cambiar_contraseña')->post('usuarios_change_password', 'Usuario\UsuarioController@changePassword');

#===================PARROCOS=========================================$
Route::resource('parrocos', 'Parroco\ParrocoController', ['except' => ['create', 'edit']]);
Route::resource('parrocos_parroquias', 'Parroco\ParrocoParroquiaController', ['except' => ['create', 'edit']]);

#===================DEPARTAMENTOS=========================================$
Route::resource('departamentos', 'Departamento\DepartamentoController', ['except' => ['create', 'edit']]);

#===================MUNICIPIOS=========================================$
Route::resource('municipios', 'Municipio\MunicipioController', ['except' => ['create', 'edit']]);

#===================PARROQUIAS=========================================$
Route::resource('parroquias', 'Parroquia\ParroquiaController', ['except' => ['create', 'edit']]);

#===================LIBROS=========================================$
Route::resource('libros', 'Libro\LibroController', ['except' => ['create', 'edit']]);

#===================FELIGRESES=========================================$
Route::resource('feligreses', 'Feligrese\FeligreseController', ['except' => ['create', 'edit']]);

#===================BAUTIZOS=========================================$
Route::resource('bautizos', 'Bautizo\BautizoController', ['except' => ['create', 'edit']]);
Route::name('bautizos_pdf')->get('bautizos_pdf/{id}', 'Bautizo\BautizoController@pdf');