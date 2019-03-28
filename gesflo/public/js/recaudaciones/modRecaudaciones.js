var moviles = null;
var multas = null;
var cobros = null;

$(document).ready(function(){
  $('#fech_desde').change(function(){
    $('#nomb_usuar').focus();
  });
});

$(document).ready(function(){
  $('#nomb_usuar').change(function(){
    $('#docu_perso').val($('#nomb_usuar').val());
  });
});

$(document).ready(function(){
  $('#btnConsultar').click(function(){
    _listarMultasDiarias();
  });
});

function _listarMultasDiarias(){
  var user_modif = $('#docu_perso').val();
  var fech_desde = $('#fech_desde').val();
  var fech_hasta = $('#fech_desde').val(); //TODO: DEFINIR UN CAMPO PARA LA FECHA FINAL
  
  var url = 'api/recaudaciones/multas/diarias/'+ user_modif +'/'+ fech_desde +'/'+ fech_hasta;
  $.ajax({
    url: url,
    type: 'GET',
    dataType:'json'
  })
  .done(function(data, textStatus, jqXHR ){
    $('#btnImprimirRecaudacionMultas').prop('disabled', false);
    _crearGraficoMultas(data);
  })
  .always(function( a, textStatus, b ) {
        //TODO
  })
  .fail(function( jqXHR, textStatus, errorThrown){
    $('#btnImprimirRecaudacionMultas').prop('disabled', true);
    $('#grafico_multas').highcharts().destroy();
    
    if (jqXHR.status == 404) {
		var title = 'Nota';
		toastr.warning(jqXHR.responseText, title);
    }
  });
}


function _listarCuotasDiarias(user_modif, desde, hasta){
  var url = 'api/recaudaciones/cuotas/diarias/'+ user_modif;
  $.ajax({
    url: url,
    type: 'GET',
    dataType:'json'
  })
  .done(function(data, textStatus, jqXHR ){
    _crearGraficoMultas(data);
  })
  .always(function( a, textStatus, b ) {
        //TODO
  })
  .fail(function( jqXHR, textStatus, errorThrown){
    if (jqXHR.status == 404) {
		var title = 'Nota';
		toastr.warning(jqXHR.responseText, title);
    }
  });
}