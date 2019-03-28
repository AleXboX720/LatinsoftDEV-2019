var objConductor = null;
var diasVencimientoLicConducir = 5;

/*###################################################################################################*/
function buscarConductor(codi_licen){
  var parametros = {'codi_licen' : codi_licen};

  var url = 'servicios/buscar/conductor';
  var token = document.getElementsByName('_token');
  $.ajax({
    url: url,
    headers : {'X-CSRF-TOKEN' : token[0].value},
    type: 'POST',
    data: parametros,
    dataType: 'json',
    beforeSend: function(){
      limpiarCamposConductor();
    },
    error: function(){
      console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
    }
  })
  .done(function(data, textStatus, jqXHR ){
    objConductor = data.conductor[0];

    var fech_vencimiento = new Date(objConductor.fech_venci);
    fech_vencimiento = fech_vencimiento.toISOString().slice(0,10);
    if(data.dias <= 0){
      alert('NOTA: \nCONDUCTOR CON LIC. CONDUCIR VENCIDA \n\n(FECHA: ' +fech_vencimiento+ ')');
      $('#btnGuardar').prop('disabled', true);
      $('#codi_licen').focus();
      $('#codi_licen').select();
    } else {
      if(data.dias <= diasVencimientoLicConducir){
        alert('NOTA: \nLA LIC. CONDUCIR VENCERA EL "' +fech_vencimiento+ '" \n\n(' +data.dias+ ' dias restantes)');
      }
      $('#docu_perso').val(objConductor.docu_perso);
      $('#prim_nombr').val(objConductor.prim_nombr);
      $('#segu_nombr').val(objConductor.segu_nombr);
      $('#apel_pater').val(objConductor.apel_pater);
      $('#apel_mater').val(objConductor.apel_mater);
      $('#fech_venci').val(objConductor.fech_venci);

      $('#hora_servi').focus();
      $('#btnGuardar').prop('disabled', false);
    }
  })
  .always(function( a, textStatus, b ) {
  //TODO
  })
  .fail(function( jqXHR, textStatus, errorThrown){
    if (jqXHR.status == 404) {
      var title = 'Atencion';
      toastr.warning(jqXHR.responseText, title);
      
      $('#btnGuardar').prop('disabled', true);
      $('#codi_licen').focus();
      $('#codi_licen').select();
    }
  });
}

function limpiarCamposConductor(){
  $('#docu_perso').val('');
  $('#prim_nombr').val('');
  $('#segu_nombr').val('');
  $('#apel_pater').val('');
  $('#apel_mater').val('');
  $('#fech_venci').val('');
}