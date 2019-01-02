var objMovil = null;
var diasVencimientoRevTecnica = 5;

/*###################################################################################################*/
function buscarMovil(nume_movil){
  var parametros = {'nume_movil' : nume_movil};

  var url = 'servicios/buscar/movil';
  var token = document.getElementsByName('_token');
  $.ajax({
    url : url,
    headers : {'X-CSRF-TOKEN' : token[0].value},
    type : 'POST',
    data: parametros,
    dataType : 'json',
    beforeSend: function(){
      limpiarCamposMovil();
    },
    error: function(){
      console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
    }
  })
  .done(function(data, textStatus, jqXHR ){
    objMovil = data.movil[0];

    var fech_vencimiento = new Date(objMovil.fech_revis);
    fech_vencimiento = fech_vencimiento.toISOString().slice(0,10);
    if(data.dias <= 0){
      alert('NOTA: \nMOVIL CON REV. TECNICA VENCIDA \n\n(FECHA: ' +fech_vencimiento+ ')');
      $('#btnGuardar').prop('disabled', true);
      $('#nume_movil').focus();
      $('#nume_movil').select();
    } else {
      if(data.dias <= diasVencimientoRevTecnica){
        alert('NOTA: \nLA REV. TECNICA VENCERA EL "' +fech_vencimiento+ '" \n\n(' +data.dias+ ' dias restantes)');
      }
      $('#codi_equip').val(objMovil.codi_equip);
      $('#fech_revis').val(objMovil.fech_revis);
      $('#pate_movil').val(objMovil.pate_movil);
      $('#codi_licen').val(objMovil.docu_condu);

      $('#codi_licen').focus();
      $('#btnGuardar').prop('disabled', false);
    }
  })
  .always(function( a, textStatus, b ) {
  //TODO
  })
  .fail(function( jqXHR, textStatus, errorThrown){
    if (jqXHR.status == 404) {
      alert(jqXHR.responseText);
      $('#btnGuardar').prop('disabled', true);
      $('#nume_movil').focus();
      $('#nume_movil').select();
    }
  });
}

function limpiarCamposMovil(){
  $('#codi_equip').val('');
  $('#fech_revis').val('');
  $('#pate_movil').val('');
}