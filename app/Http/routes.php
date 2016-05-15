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
/*Páginas del sitio principal*/
Route::get('/', 'SitioControllador@pagina_principal');
Route::get('/recetas/{id}', 'SitioControllador@recetas');
Route::get('/productos/', 'SitioControllador@productos');
Route::get('/producto/{id}', 'SitioControllador@producto_individual');
Route::get('/recetas/', 'SitioControllador@recetas_lista');
Route::get('/acerca_de/', 'SitioControllador@acerca_de');
Route::get('/contacto/', 'SitioControllador@contacto');
Route::post('/salvar_contacto/', 'SitioControllador@salvar_contacto');

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
Route::any('/admin_proveedores/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminProveedoresControllador@principal');
Route::any('/admin_clientes/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminClientesControllador@principal');
Route::any('/admin_procesos/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminProcesosControllador@principal');
Route::any('/admin_reportes/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminReportesControllador@principal');
Route::any('/admin_contenidos/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'AdminContenidosControllador@principal');
Route::any('/perfil/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'PerfilControlador@principal');
Route::any('/seguimientos/{extra?}/{extra2?}/{extra3?}/{extra4?}/{extra5?}/{extra6?}', 'SeguimientosControllador@principal');


