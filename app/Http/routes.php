<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Esta sentencia manda la dirección de "ingresar" al controlador para que muestre la página respectiva
Route::get('/ingresar', 'IngresoControllador@ingreso');
Route::get('/recordar', 'IngresoControllador@recordar');