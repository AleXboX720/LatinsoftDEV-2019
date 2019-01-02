$(document).ready(function(){
	listarGeozonas();
});

$(document).ready(function(){
	$('#nomb_geozo').keypress(function(e){
		if(e.which == 13){
			var nomb_geozo = $(this).val();
			if(nomb_geozo.length > 0){
				filtrarGeozona(nomb_geozo);
			} else {
				listarGeozonas();
			}
		}
	});
});

function listarGeozonas(){
	var url = 'listar/geozonas';
    
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'json',
		beforeSend: function(){
			$('#tablaListadoGeozonas').html('');
		},
		success: function(response){
			listado = response.listado;

			//mostrarMensaje(obj.msg, 'alert-success');
			var listaHTML = _lstHtmlMoviles(listado);
			$('#tablaListadoGeozonas').html(listaHTML);
			},
			error: function(){
			console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
		}
	});
}

function filtrarGeozona(nomb_geozo){
	var url = 'filtrar/geozona';
	var parametros = {"nomb_geozo" : nomb_geozo};
  
    
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
	data: parametros,
    beforeSend: function(){
      $('#tablaListadoGeozonas').html('');
    },
    success: function(response){
		listado = response.listado;
	  
      //mostrarMensaje(obj.msg, 'alert-success');
	  var listaHTML = _lstHtmlMoviles(listado);
      $('#tablaListadoGeozonas').html(listaHTML);
    },
    error: function(){
      console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
    }
  });
}

function _lstHtmlMoviles(listado){
	var elHtml = '';
	var cont = 0;
	$.each(listado, function(i, obj){
		if (obj.isActive == 1)
		{
		  elHtml += '<tr class="success" data-codi_geozo="' +obj.geozoneID+'">';
		} else {
		  elHtml += '<tr class="danger" data-codi_geozo="' +obj.geozoneID+ '">';
		}
			elHtml += '<td class="text-center"><b>' +obj.geozoneID+ '</b></td>';
			elHtml += '<td class="text-nowrap text-center">';
			elHtml += '<a href="geozonas/' +obj.geozoneID+'/edit" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span></<a>';
			elHtml += '<a href="#!" class="btn btn-xs btn-success btnVerMapa" data-toggle="modal" data-target="#modal_mapa"><span class="glyphicon glyphicon-eye-open" aria hidden="true"></span></a>';
			elHtml += '<a href="#!" class="btn btn-xs btn-danger btnEliminar" disabled><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a>';
			elHtml += '</td>';			
			elHtml += '<td class="">' +obj.description+ '</td>';
			elHtml += '<td class="text-center">' +obj.displayName+ '</td>';	

		elHtml += '</tr>';
	});
  return elHtml;
}
