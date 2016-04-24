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

\App::setLocale("es"); //Por medio de esta linea se cambia el idioma general de la aplicación. Por el momento no se planea hacer multilenguaje así que no importa que esté quemado en el código

Route::get('/', function () {
    return view('welcome');
});

//Esta sentencia manda la dirección de "ingresar" al controlador para que muestre la página respectiva
Route::get('/ingresar', 'IngresoControllador@ingreso');
Route::post('/ingresar', 'IngresoControllador@accion_ingresar');
Route::get('/recordar', 'IngresoControllador@recordar');
Route::post('/recordar', 'IngresoControllador@accion_recordar');
Route::any('/cerrar_sesion', 'IngresoControllador@accion_salir');
Route::get('/recobrar/{codigo}', 'IngresoControllador@recobrar');
Route::post('/recobrar/{codigo}', 'IngresoControllador@accion_recobrar');


//Rutas de correo: las siguientes rutas no deberían ser accesibles para nadie excepto los que sabemos que están aquí
Route::get('/correo_demostracion/basico/verde', function () {
    return view('correo.basica');
});

//Áreas de administración general
Route::any('/general/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'GeneralControllador@principal');
Route::any('/admin_general/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminGeneralControllador@principal');
Route::any('/admin_usuarios/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminUsuariosControllador@principal');
Route::any('/admin_productos/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminProductosControllador@principal');
Route::any('/perfil/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'PerfilControlador@principal');
Route::any('/seguimientos/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'SeguimientosControllador@principal');
