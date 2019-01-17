function crearServicio(servicio, conductor, movil, programadas){
	var url = 'servicio/registrar';

	var parametros = {'servicio' : servicio, 'conductor' : conductor, 'movil' : movil, 'programadas' : programadas};
	var token = document.getElementsByName("_token");
	$.ajax({
		url : url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type : 'POST',
		dataType : 'json',
		data : parametros
	})
	.done(function(data, textStatus, jqXHR ){
		listarServicios();
	})
	.always(function( a, textStatus, b ) {
		//TODO
	})
	.fail(function( jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
		alert(jqXHR.responseText);
		}
	});
}

function buscandoServicio(codi_circu, nume_movil, pate_movil, codi_servi){
	var parametros = {'codi_servi' : codi_servi, 'codi_circu' : codi_circu, 'nume_movil' : nume_movil, 'pate_movil' : pate_movil};

	var url = 'servicio/buscar';
	var token = document.getElementsByName("_token"); 
	return $.ajax({
		url : url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type : 'POST',
		data: parametros,
		dataType : 'json',
		beforeSend: function(){},
		error: function(){
			console.log('Lamentablemente Hay un Error de Coneccion AJAX, Intentelo Mas Tarde!!!');
		}
	})
	.done(function(data, textStatus, jqXHR ){
	})
	.always(function( a, textStatus, b ) {
	//TODO
	})
	.fail(function( jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
			var title = 'Felicidades';
			toastr.error(jqXHR.responseText, title);
		}
	});
}

function eliminandoServicio(codi_circu, nume_movil, pate_movil, codi_servi){
	var parametros = {'codi_servi' : codi_servi, 'codi_circu' : codi_circu, 'nume_movil' : nume_movil, 'pate_movil' : pate_movil};

	var url = 'servicio/eliminar';
	var token = document.getElementsByName("_token"); 
	return $.ajax({
		url : url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type : 'POST',
		data: parametros,
		dataType : 'json',
		beforeSend: function(){},
		error: function(){
		console.log('Lamentablemente Hay un Error de Coneccion AJAX, Intentelo Mas Tarde!!!');
		}
	})
	.done(function(data, textStatus, jqXHR ){
	})
	.always(function( a, textStatus, b ) {
	//TODO
	})
	.fail(function( jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
		alert(jqXHR.responseText);
		}
	});
}

function existeServicio(codi_circu, codi_servi){
	var parametros = {'codi_servi' : codi_servi, 'codi_circu' : codi_circu};

	var url = 'servicio/existe';
	var token = document.getElementsByName("_token"); 
	return $.ajax({
		url : url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type : 'POST',
		data: parametros,
		dataType : 'json',
		beforeSend: function(){},
		error: function(){
		console.log('Lamentablemente Hay un Error de Coneccion AJAX, Intentelo Mas Tarde!!!');
		}
	})
	.done(function(data, textStatus, jqXHR ){
	})
	.always(function( a, textStatus, b ) {
	//TODO
	})
	.fail(function( jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
		alert(jqXHR.responseText);
		}
	});
}

function serviciosPendientes(codi_circu, nume_movil, pate_movil){
	var fech_servi = new Date($('#fech_servi').val());
	var parametros = {'codi_circu' : codi_circu, 'nume_movil' : nume_movil, 'pate_movil' : pate_movil, 'fech_servi' : fech_servi};

	var url = 'servicios/pendientes';
	var token = document.getElementsByName("_token"); 
	return $.ajax({
		url : url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type : 'POST',
		data: parametros,
		dataType : 'json',
		beforeSend: function(){},
		error: function(){
		console.log('Lamentablemente Hay un Error de Coneccion AJAX, Intentelo Mas Tarde!!!');
		}
	})
	.done(function(data, textStatus, jqXHR ){
	})
	.always(function( a, textStatus, b ) {
	//TODO
	})
	.fail(function( jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
		alert(jqXHR.responseText);
		}
	});
}

function actualizarServicio(listado){
	var url = 'actualizar/servicios';
	var token = document.getElementsByName("_token");  

	var parametros = {'listado' : listado};
	$.ajax({
	url: url,
	headers : {'X-CSRF-TOKEN' : token[0].value},
	type: 'PUT',
	data: parametros,
	dataType: 'json',
	beforeSend: function(){},
	error: function(){
	  console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
	}
	});
}

function imprimirServicio(servicio, controladas){
	var url = 'servicio/imprimir';
	
	var parametros = {'servicio' : servicio, 'controladas' : controladas};
	
	var token = document.getElementsByName("_token");
	$.ajax({
		url: url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type: 'POST',
		data: parametros,
		beforeSend: function(){},
		success: function(){},
		error: function(){
			mostrarMensaje('ALGO SALIO MAL AL IMPRIMIR', 'alert-danger');
		}
	});	
}