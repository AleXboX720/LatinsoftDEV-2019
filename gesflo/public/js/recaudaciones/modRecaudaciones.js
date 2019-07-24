var moviles = null;
var multas = null;
var cobros = null;
var totales = null;

$(document).ready(function(){
  $('#fech_desde').change(function(){
    $('#nomb_usuar').focus();
    _listarMultasDiarias();
  });
});

$(document).ready(function(){
  $('#nomb_usuar').change(function(){
    $('#docu_perso').val($('#nomb_usuar').val());
    _listarMultasDiarias();
  });
});

$(document).ready(function(){
  $('#btnConsultar').click(function(){
    _listarMultasDiarias();
  });
});

$(document).ready(function(){
  $('#btnImprimirRecaudacionMultas').click(function(){
    _imprimirRecaudacionPagos(totales);
  });
});

function _listarMultasDiarias(){
  var fech_desde = $('#fech_desde').val();
  var fech_hasta = $('#fech_desde').val(); //TODO: DEFINIR UN CAMPO PARA LA FECHA FINAL???
  

  var u = $('#docu_perso').val();
  var d = new Date(fech_desde).toJSON().slice(0, 10);
  var h = new Date(fech_hasta).toJSON().slice(0, 10);

  //var url = 'api/recaudaciones/multas/diarias/'+ d +'/'+ h +'/'+ u;
  var url = 'http://avl.kguard.org:81/laravel/public/api/recaudaciones/multas/diarias/2019-05-14/2019-05-14/11343736';
  $.ajax({
    url: url,
    type: 'GET',
    dataType:'json'
  })
  .done(function(data, textStatus, jqXHR ){
    $('#btnImprimirRecaudacionMultas').prop('disabled', false);
    _crearGraficoMultas(data);
    totales = data.totales;
  })
  .always(function( a, textStatus, b ) {
        //TODO
  })
  .fail(function( jqXHR, textStatus, errorThrown){
    if (jqXHR.status == 404) {
  		var title = 'Nota';
  		toastr.warning(jqXHR.responseText, title);
      $('#btnImprimirRecaudacionMultas').prop('disabled', true);
      $('#grafico_multas').highcharts().destroy();      
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

function _imprimirRecaudacionPagos(totales){
  alert('CLICK OK'); 
  var fech_desde = $('#fech_desde').val();
  var total_multas = totales.total_multas;
  var total_cobros = totales.total_cobros;

  //var url = 'api/imprimir/recaudacion/multas/' +fech_desde +'/'+ total_multas +'/'+ total_cobros;
  
  $.ajax({
    url: url,
    type: 'GET',
    dataType:'json'
  })
  .done(function(data, textStatus, jqXHR ){
    console.dir(data);
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