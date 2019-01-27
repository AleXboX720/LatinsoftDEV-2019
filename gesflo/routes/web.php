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

Route::get('/', 'BienvenidaController@index')->name('bienvenida');
Route::get('/bienvenida', 'BienvenidaController@index');

Route::group(['prefix' => 'gestion'], function(){
	Route::resource('servicios', 		'Gestion\ServiciosController', ['only' => ['index']]);

	Route::post('servicio/registrar', 	'Gestion\ServiciosController@store')->name('registrar.servicio');

	Route::put('actualizar/servicios', 	'Gestion\ServiciosController@actualizarServicio')->name('actualizar.servicio');
	Route::post('servicios/procesar', 	'Gestion\ServiciosController@procesarListadoServicios')->name('servicios.procesar');

	Route::post('servicio/buscar', 		'Gestion\ServiciosController@buscarServicio')->name('buscar.servicio');
	Route::post('servicios/filtrar', 	'Gestion\ServiciosController@filtrarServicios')->name('filtrar.servicio');
	Route::post('servicio/eliminar', 	'Gestion\ServiciosController@eliminarServicio')->name('eliminar.servicio');
	Route::get('servicios/listar', 		'Gestion\ServiciosController@listarServicios')->name('listar.servicios');

	Route::post('servicios/finalizar', 	'Gestion\ServiciosController@finalizarServicios')->name('servicios.finalizar');
	Route::post('servicios/procesar', 	'Gestion\ServiciosController@procesarServicios')->name('servicios.procesar');
	Route::post('listar/expediciones', 	'Gestion\ExpedicionesController@listarExpediciones2')->name('expediciones.servicio');
	
	Route::post('servicios/pendientes', 'Gestion\ServiciosController@serviciosPendientes')->name('servicios.pendiente');
	Route::post('servicio/existe', 		'Gestion\ServiciosController@existeServicio')->name('existe.servicio');

	Route::put('actualizar/programadas', 'Gestion\ProgramadasController@update')->name('actualizar.programadas');


	Route::post('multas/pagar', 		'Gestion\MultasController@pagarMulta')->name('pagar.multa');
	
	
	//Route::resource('trackers', 'TrackersController', ['parameters' => ['nume_devic' => 'nume_devic']]);
	Route::post('servicio/imprimir', 'Imprimir\ServiciosController@imprimir')->name('imprimir.servicio');
	Route::post('informe/imprimir', 'Imprimir\InformesController@imprimir')->name('imprimir.informe');

	
	
	Route::post('detallar/circuito', 	'Admin\CircuitosController@detallarCircuito')->name('detallar.circuito');
	Route::post('listar/arribos', 		'Track\ArribosController@listarArribos')->name('listar.arribos');


	Route::post('servicios/buscar/movil', 		'Gestion\ServiciosController@buscarMovil');
	Route::post('servicios/buscar/conductor', 	'Gestion\ServiciosController@buscarConductor');
});

Route::get('/manager', 			'Manager\ManagerController@index')->name('manager');
Route::get('/administracion', 	'Admin\AdministracionController@index')->name('administracion');





//RUTAS: ADMINISTRACION
Route::group(['prefix' => 'adm'], function(){
	Route::resource('usuarios', 'Admin\UsuariosController');
	Route::resource('empresas', 'Admin\EmpresasController');
	//=======================================================================//
	

	//=======================================================================//
	Route::resource('geozonas', 'Admin\GeozonasController', ['only' => ['index', 'show', 'edit']]);
	Route::get('filtrar/geozona', 'Admin\GeozonasController@filtrarGeozonas')->name('filtar.geozona');
	Route::get('listar/geozonas', 'Admin\GeozonasController@listarGeozonas');
	//Route::get('geozonas/listar', 'Admin\GeozonasController@listarGeozonas')->name('geozonas.listar');
	//=======================================================================//
	Route::resource('rutas', 'Admin\RutasController', ['only' => ['index', 'show', 'edit', 'update']]);
	Route::get('filtrar/ruta', 'Admin\RutasController@filtrarRutas')->name('filtar.ruta');
	Route::get('listar/rutas', 'Admin\RutasController@listarRutas');
	Route::get('rutas/{codi_ruta}/buscar/ruta', 'Admin\RutasController@show');
	//=======================================================================//
	Route::resource('circuitos', 'Admin\CircuitosController');
	Route::get('filtrar/circuito', 'Admin\CircuitosController@filtrarCircuitos')->name('filtar.circuito');
	Route::get('listar/circuitos', 'Admin\CircuitosController@listarCircuitos');
});

//RUTAS: MANAGER
Route::group(['prefix' => 'mng'], function(){
	Route::resource('conductores', 'Manager\ConductoresController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
	
	Route::get('listar/conductores', 'Manager\ConductoresController@listarConductores');
	Route::get('filtrar/conductor', 'Manager\ConductoresController@filtrarConductor')->name('filtrar.conductor');	
	//=======================================================================//
	Route::resource('moviles', 'Manager\MovilesController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);

	

	Route::get('moviles/listar', 'Manager\MovilesController@listarMoviles');
	Route::get('moviles/filtrar', 'Manager\MovilesController@filtrarMovil')->name('filtrar.movil');
	//=======================================================================//
	Route::resource('equipos', 	'Manager\EquiposController', 	['parameters' => ['docu_empre' => 'docu_empre']]);
	
	Route::get('listar/equipos', 'Manager\EquiposController@listarEquipos');
	Route::get('buscar/equipo', 'Manager\EquiposController@buscarEquipo')->name('buscar.equipo');
	//=======================================================================//
	
	Route::resource('propietarios', 'Manager\PropietariosController');
	Route::get('buscar/propietario/{docu_perso}', 'Manager\PropietariosController@show');


	Route::get('listar/propietarios', 'Manager\PropietariosController@listarPropietarios');
	Route::get('filtrar/propietario', 'Manager\PropietariosController@filtrarPropietario')->name('filtrar.propietario');
	//=======================================================================//
	Route::resource('expediciones', 'Gestion\ExpedicionesController', ['parameters' => ['docu_empre' => 'docu_empre']]);

	Route::get('expediciones/listar', 'Gestion\ExpedicionesController@listarExpediciones')->name('expediciones.listar');
});

Route::get('/admin', function () {
	$data['title'] 		= 'ADMINISTRACION';
	$data['subtitle'] 	= 'ejemplo';
	
    return view('admin.dashboard', compact('data'));
});


 // Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
