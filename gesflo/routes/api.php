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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//MONITORES DEL SISTEMA
//http://localhost/laravel/public/api/servicios/96711420/18
Route::get('/servicios/{docu_empre}/{codi_circu}', 'MonitoresController@index');

//INFORMES DEL SISTEMA
Route::get('/conductores/servicio/{codi_circu}/{codi_servi}', 'InformesController@miServicio');
Route::get('/tpublico/antofagasta/expediciones/{codi_linea}/{docu_empre}/{docu_perso}/{anio_consu}/{mes_consu}', 'InformesController@expedicionesFlota');


Route::get('/propietarios/flota/{codi_linea}/{docu_empre}/{docu_perso}', 'InformesController@informeMiFlota');