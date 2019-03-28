$(document).ready(function(){
	listarMoviles();
});

$(document).ready(function(){
	$('#pate_movil').keypress(function(e){
		if(e.which == 13){
			var pate_movil = $(this).val();
			if(pate_movil.length > 0){
				filtrarMovil(pate_movil);
			} else {
				listarMoviles();
			}
		}
	});
});

function listarMoviles(){
  var url = 'moviles/listar';
  
    
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function(){
      $('#tablaListadoMoviles').html('');
    },
    error: function(){
      console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
    }
  })
  .done(function(data, textStatus, jqXHR ){
	listado = data.listado;

	//mostrarMensaje(obj.msg, 'alert-success');
	var listaHTML = _lstHtmlMoviles(listado);
	$('#tablaListadoMoviles').html(listaHTML);

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

function filtrarMovil(pate_movil){
	var url = 'moviles/filtrar';
	var parametros = {"pate_movil" : pate_movil};
  
    
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
	data: parametros,
    beforeSend: function(){
      $('#tablaListadoMoviles').html('');
    },
    success: function(response){
		listado = response.listado;
	  
      //mostrarMensaje(obj.msg, 'alert-success');
	  var listaHTML = _lstHtmlMoviles(listado);
      $('#tablaListadoMoviles').html(listaHTML);
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
		if (obj.habilitado == 1)
		{
		  elHtml += '<tr class="success" data-idde_objet="' +obj.nume_movil+'">';
		} else {
		  elHtml += '<tr class="danger" data-idde_objet="' +obj.pate_movil+ '">';
		}
			elHtml += '<td class="text-center"><b>' +obj.nume_movil+ '</b></td>';
			elHtml += '<td class="text-center"><b>' +obj.pate_movil+ '</b></td>';
			elHtml += '<td class="text-center">' +obj.codi_equip+ '</td>';

			var fech_revis = new Date(obj.fech_revis);
			var fecha = fech_revis.toLocaleDateString();
			elHtml += '<td class="text-nowrap text-center">' +fecha+ '</td>';
			elHtml += '<td class="text-center hidden-sm hidden-xs">' +obj.anio_movil+ '</td>';
			elHtml += '<td class="text-nowrap hidden-sm hidden-xs">' +obj.propietario+ '</td>';
			elHtml += '<td class="text-center">' +obj.imei_equip+ '</td>';
			elHtml += '<td class="text-center">' +obj.nume_telef+ '</td>';
			
			elHtml += '<td class="text-nowrap">';
			elHtml += '<a href="moviles/' +obj.nume_movil+'/edit" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span></<a>';
			elHtml += '<a href="#!" class="btn btn-xs btn-danger btnEliminar"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a>';
			elHtml += '</td>';

		elHtml += '</tr>';
	});
  return elHtml;
}