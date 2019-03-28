$(document).ready(function(){
	listarConductores();
});

$(document).ready(function(){
	$('#apel_pater').keypress(function(e){
		if(e.which == 13){
			var apel_pater = $(this).val();
			if(apel_pater.length > 0){
				filtrarConductores(apel_pater);
			} else {
				listarConductores();
			}
		}
	});
});

function listarConductores(){
  var url = 'listar/conductores';
  
    
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'json',
		beforeSend: function(){
			$('#tablaListadoPersonas').html('');
		},
		error: function(){
			console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
		}
	})
	.done(function(data, textStatus, jqXHR ){
    	listado = data.listado;
		//mostrarMensaje(obj.msg, 'alert-success');
		var listaHTML = _lstHtmlConductores(listado);
		$('#tablaListadoPersonas').html(listaHTML);
	})
	.always(function( a, textStatus, b ) {
		//TODO
	})
	.fail(function( jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
			alert(jqXHR.responseText);
			$("#btnGuardar").prop('disabled', true);
			$("#nume_movil").focus();
			$("#nume_movil").select();
		}
	});
}

function filtrarConductores(apel_pater){
	var url = 'filtrar/conductor';
	var parametros = {"apel_pater" : apel_pater};


	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'json',
		data: parametros,
		beforeSend: function(){
			$('#tablaListadoPersonas').html('');
		},
		error: function(){
			console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
		}
	})
	.done(function(data, textStatus, jqXHR ){
    	listado = data.listado;
		//mostrarMensaje(obj.msg, 'alert-success');
		var listaHTML = _lstHtmlConductores(listado);
		$('#tablaListadoPersonas').html(listaHTML);
	})
	.always(function( a, textStatus, b ) {
		//TODO
	})
	.fail(function( jqXHR, textStatus, errorThrown){
		if (jqXHR.status == 404) {
			alert(jqXHR.responseText);
			$("#btnGuardar").prop('disabled', true);
			$("#nume_movil").focus();
			$("#nume_movil").select();
		}
	});
}

function _lstHtmlConductores(listado){
	var elHtml = '';
	var cont = 0;
	  $.each(listado, function(i, obj){

		if (obj.habilitado == 1)
		{
		  elHtml += '<tr class="success" data-idde_objeto="' +obj.docu_perso+'">';
		} else {
		  elHtml += '<tr class="danger" data-idde_objeto="' +obj.docu_perso+ '">';
		}
		elHtml += '<td class="text-right"><b>' +obj.codi_licen+ '</b></td>';
		elHtml += '<td class="text-center">';
		elHtml += '<a href="conductores/' +obj.docu_perso+'/edit" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span></<a>';
		elHtml += '<a href="#!" class="btn btn-xs btn-danger btnEliminar"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a>';
		elHtml += '</td>';
		elHtml += '<td class="text-nowrap">' +obj.prim_nombr+ ' ' +obj.segu_nombr+ '</td>';
		elHtml += '<td class="text-nowrap">' +obj.apel_pater+ ' ' +obj.apel_mater+ '</td>';
		elHtml += '<td class="text-nowrap">' +obj.nomb_domic+ ' #' +obj.nume_domic+ '</td>';
		elHtml += '<td class="text-center">' +obj.tele_conta+ '</td>';
		elHtml += '<td class="text-center">' +obj.movi_conta+ '</td>';
		elHtml += '<td class="text-right">' +obj.mail_conta+ '</td>';

		elHtml += '</tr>';
	  });
  return elHtml;
}