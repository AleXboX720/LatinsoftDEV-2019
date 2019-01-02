$(document).ready(function(){
	listarEquipos();
});

$(document).ready(function(){
	$('#nume_imei').keypress(function(e){
		if(e.which == 13){
			var nume_imei = $(this).val();
			if(nume_imei.length > 0){
				buscarEquipos(nume_imei);
			} else {
				listarEquipos();
			}
		}
	});
});

function listarEquipos(){
  var url = 'listar/equipos';
  
    
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
    beforeSend: function(){
      $('#tablaListadoEquipos').html('');
    },
    success: function(response){
		listado = response.listado;
	  
      //mostrarMensaje(obj.msg, 'alert-success');
	  var listaHTML = _lstHtmlMoviles(listado);
      $('#tablaListadoEquipos').html(listaHTML);
    },
    error: function(){
      console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
    }
  });
}

function buscarEquipos(nume_imei){
	var url = 'buscar/equipo';
	var parametros = {"nume_imei" : nume_imei};
  
    
  $.ajax({
    url: url,
    type: 'GET',
    dataType: 'json',
	data: parametros,
    beforeSend: function(){
      $('#tablaListadoEquipos').html('');
    },
    success: function(response){
		listado = response.listado;
	  
      //mostrarMensaje(obj.msg, 'alert-success');
	  var listaHTML = _lstHtmlMoviles(listado);
      $('#tablaListadoEquipos').html(listaHTML);
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
		  elHtml += '<tr class="success" data-idde_objet="' +obj.imeiNumber+'">';
		} else {
		  elHtml += '<tr class="danger" data-idde_objet="' +obj.imeiNumber+ '">';
		}
			elHtml += '<td class="text-center"><b>' +obj.deviceID+ '</b></td>';
			elHtml += '<td class="text-nowrap text-center">';
				elHtml += '<a href="equipos/' +obj.deviceID+'/edit" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span></<a>';
				elHtml += '<a href="#!" class="btn btn-xs btn-danger btnEliminar"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a>';
			elHtml += '</td>';			
			elHtml += '<td class="text-center"><b>' +obj.imeiNumber+ '</b></td>';
			elHtml += '<td class="text-center">' +obj.simPhoneNumber+ '</td>';
			elHtml += '<td class="text-center">' +obj.licensePlate+ '</td>';
			elHtml += '<td class="text-center hidden-sm hidden-xs">' +obj.serialNumber+ '</td>';

			var fech_revis = new Date(obj.lastGPSTimestamp * 1000);
			var fecha = fech_revis.toLocaleDateString();
			elHtml += '<td class="text-nowrap text-center hidden-sm hidden-xs">' +fecha+ '</td>';
			

		elHtml += '</tr>';
	});
  return elHtml;
}
