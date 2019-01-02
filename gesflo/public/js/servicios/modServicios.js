var fech_servicio = null;
var codi_circuito = null;
var nume_maquina = null;
var hora_inicio = null;
var codi_servicio = null;
/*###################################################################################################*/
$(document).ready(function(){
  $('#fech_servi').change(function(){
    verificarCambios();
    $('#codi_circu').focus();
  });
});
/*###################################################################################################*/
$(document).ready(function(){
  $('#codi_circu').change(function(){
    codi_circuito = $('#codi_circu').val();
    $('#copi_numer').val(codi_circuito);
    verificarCambios();
    listarPuntosControlar();
  });
});
/*###################################################################################################*/
$(document).ready(function(){
  $('#nume_movil').keypress(function(e){
    if(e.which == 13){
      nume_maquina = $('#nume_movil').val();
      buscarMovil(nume_maquina);
    }
  });
});
/*###################################################################################################*/
$(document).ready(function(){
  $('#codi_licen').keypress(function(e){
    if(e.which == 13){
      codi_licen = $('#codi_licen').val();
      buscarConductor(codi_licen);
	}
  });
});
/*###################################################################################################*/
$(document).ready(function(){
  $('#hora_servi').keypress(function(e){
    if(e.which == 13){
      $('#btnGuardar').focus();
    }
  });
});
/*###################################################################################################*/
$(document).ready(function(){
	$('#btnGuardar').click(function(e){
		e.preventDefault();
		guardarServicio();
	});
});
/*###################################################################################################*/
function verificarCambios(){
  fech_servicio = $('#fech_servi').val();
  if(codi_circuito !== null){
    listarServicios();
    $('#btnAgregar').prop('disabled', false);
  } else {
    $('#btnAgregar').prop('disabled', true);
  }
}
/*###################################################################################################*/
function limpiarCampos(){
  $('#nume_movil').val('');
  $('#codi_equip').val('');
  $('#fech_revis').val('');
  $('#pate_movil').val('');
  $('#codi_licen').val('');
  $('#docu_perso').val('');
  $('#prim_nombr').val('');
  $('#segu_nombr').val('');
  $('#apel_pater').val('');
  $('#apel_mater').val('');
  $('#fech_venci').val('');
  $('#nume_movil').focus();
}