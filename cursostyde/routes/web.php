<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios', 'UserController@index')->name('users.index');

Route::get('/usuarios/practica', 'UserController@practica');

Route::get('/usuarios/nuevo', 'UserController@create');

Route::post('/usuarios/crear', 'UserController@store');

//Route::get('/usuarios/{id}', 'UserController@show')->name('users.show');
Route::get('/usuarios/{user}', 'UserController@show')->name('users.show');

Route::get('/saludo/{name}/{nickname?}', 'WelcomeUserController');

//Route::get('/usuarios/{id}/editar', 'UserController@edit')->where('id', '[0-9]+');

Route::get('/usuarios/{user}/editar', 'UserController@edit')->name('users.edit');

Route::put('/usuarios/{user}', 'UserController@update');

Route::delete('/usuarios/{user}', 'UserController@destroy')->name('users.delete');
