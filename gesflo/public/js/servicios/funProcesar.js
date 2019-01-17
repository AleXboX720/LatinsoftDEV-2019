var lstIniciados = [];
var lstServiciosProcesar = [];

$(document).ready(function(){
	$('#btnProcesar').click(function(e){
		console.clear();
		var finalizados = finalizarServicios();
		finalizados.done(function(data, textStatus, jqXHR){
			if(data.total > 0){
				var procesar = procesarServicios();
				procesar.done(function(data, textStatus, jqXHR){
					$.each(data.listado, function(i, servicio){
						var expediciones = listarExpediciones2(servicio);
						expediciones.done(function(data, textStatus, jqXHR){
							$.each(data.listado, function(i, expedicion){
						        var marcadas = listarArribos(expedicion);
						        marcadas.done(function(data, textStatus, jqXHR){
									animarBarraProgreso(0);
									var actualizadas = actualizarProgramadas(data);
									actualizadas.done(function(data, textStatus, jqXHR){
										//alert(data.status);
										$('#modal_procesar').modal('hide');
									});
									animarBarraProgreso((100 / data.total) * data.total, data.nume_movil);
								
								});
							});
						});
					});
				});
			}
		});
		setTimeout(listarServicios, 2000);
	});
});

function finalizarServicios(){
	var url = 'servicios/finalizar';
	var token = document.getElementsByName('_token');

	var parametros = {'fech_servi' : fech_servicio, 'codi_circu' : codi_circuito};

	return $.ajax({
		url: url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type: 'POST',
		data: parametros,
		dataType: 'json',
		beforeSend: function(){}
	})
	.done(function(data, textStatus, jqXHR){
		//console.log(data.msg);
		var title = 'Nota';
		toastr.info(data.msg, title);
	})
	.always(function(a, textStatus, b) {
		//TODO
	})
	.fail(function(jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
			var title = 'Felicidades';
			toastr.success(jqXHR.responseText, title);
		}
	});
}

function procesarServicios(){
	var url = 'servicios/procesar';
	var token = document.getElementsByName('_token');

	var parametros = {'fech_servi' : fech_servicio, 'codi_circu' : codi_circuito};

	return $.ajax({
		url: url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type: 'POST',
		data: parametros,
		dataType: 'json',
		beforeSend: function(){
			$('#listadoProcesar').html('');
			$('#total_finalizados').html('');
		}
	})
	.done(function(data, textStatus, jqXHR){
		console.log(data.msg);
		var listaHTML = _lstHtmlServiciosProcesar(data.listado);
		$('#listadoProcesar').html(listaHTML);
		$('#total_finalizados').html(data.total);
	})
	.always(function(a, textStatus, b) {
		//TODO
	})
	.fail(function(jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
			console.log(jqXHR.responseText, title);
		}
	});
}

function listarExpediciones2(servicio){
	var url = 'listar/expediciones';
	var token = document.getElementsByName('_token');


	var parametros = {'servicio' : servicio};
	return $.ajax({
      url: url,
      headers : {'X-CSRF-TOKEN' : token[0].value},
      type: 'POST',
      data: parametros,
      dataType: 'json',
      beforeSend: function(){}
    })
	.done(function(data, textStatus, jqXHR){
		console.log(data.msg);
	})
	.always(function(a, textStatus, b) {
		//TODO
	})
	.fail(function(jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {			
			console.log(jqXHR.responseText);
		}
	});
}

function listarArribos(expedicion){
	var url = 'listar/arribos';
	var token = document.getElementsByName('_token');
	
	var parametros = {'expedicion' : expedicion};
	
	return $.ajax({
		url: url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type: 'POST',
		data: parametros,
		dataType: 'json',
		beforeSend: function(){}
	})
	.done(function(data, textStatus, jqXHR){
		$('#totalServicios').html(data.sentido);
		$('#procesandoServicio').html(data.codi_servi);
		$('#totalMarcadas').html(data.total);
	})
	.always(function(a, textStatus, b) {
		//TODO
	})
	.fail(function(jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
			var title = 'Lamentablemente';
			toastr.error(jqXHR.responseText, title);
		}
	});
}

function actualizarProgramadas(data){
	var url = 'actualizar/programadas';
  	var token = document.getElementsByName('_token');  

	var parametros = {'marcadas' : data.listado, 
	'codi_servi' : data.codi_servi, 
	'codi_circu' : data.codi_circu, 
	'codi_senti' : data.codi_senti, 
	'nume_movil' : data.nume_movil, 
	'pate_movil' : data.pate_movil};
	return $.ajax({
		url: url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type: 'PUT',
		data: parametros,
		dataType: 'json',
		beforeSend: function(){
			$('#modal_procesar').modal('show');			
		}
	})
	.done(function(data, textStatus, jqXHR){
		console.log(data.msg);
	})
	.always(function(a, textStatus, b) {
		//TODO
	})
	.fail(function(jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
			console.log(jqXHR.responseText);
		}
	});
}

/*###################################################################################################*/
function animarBarraProgreso(porcentaje, movil){
	$('#barraProsesandoServicios').css({'width': porcentaje +'%'});

	$('#elPorcentaje1').html(parseInt(porcentaje) +'% Completado');
	$('#nume_movilXXX').html(movil);
	$('#barraProsesandoServicios').html(porcentaje +'%');
}

function _lstHtmlServiciosProcesar(listado){
	var elHtml = '';
	$.each(listado, function(i, obj){
		elHtml += '<a href="#" ';
				elHtml += 'data-codi_circu="' +obj.codi_circu+ '" ';
				elHtml += 'data-codi_servi="' +obj.codi_servi+ '" ';
				elHtml += 'data-nume_movil="' +obj.nume_movil+ '" ';
				elHtml += 'data-pate_movil="' +obj.pate_movil+ '">';
			elHtml += '<b>Maq ' +obj.nume_movil+ '</b>';
			elHtml += '<small class="pull-right">' +obj.nume_movil+ '%</small>';
			elHtml += '<div class="progress lg">';
				elHtml += '<div class="progress-bar progress-bar-aqua" style="width: ' +obj.nume_movil+ '%" aria-valuenow="' +obj.nume_movil+ '" role="progressbar">';
				elHtml += '</div>';
			elHtml += '</div>';
		elHtml += '</a>';
	});
  return elHtml;
}