$(document).ready(function(){
	listarConductores();
});

$(document).ready(function(){
	$('#btnActualizar').click(function(e){
		var formulario = $('#frmEditar').serialize();
		var actualizacion = actualizarConductor(formulario);
		actualizacion.done(function(data, textStatus, jqXHR ){
			$('#modal_editar').modal('hide');
			listarConductores();
		});
	});
});

function actualizarConductor(formulario){
	var parametros = formulario;
	var token = document.getElementsByName("_token");
	var url = 'conductores/actualizar';
	return $.ajax({
		url : url,
		headers : {'X-CSRF-TOKEN' : token[0].value},
		type : 'PUT',
		data: parametros,
		dataType : 'json',
		beforeSend: function(){},
	})
	.done(function(data, textStatus, jqXHR ){
		if (jqXHR.status == 200) {
			var title = 'Nota';
			toastr.info(data.msg, title);
		}
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

function _cargarCampos(data){
	var persona = data.objPersona[0];
	var domicilio = data.objDomicilio[0];
	var contacto = data.objContacto[0];
	var conductor = data.objConductor[0];
	var licencia = data.objLicencia[0];
	_datosPersona(persona);
	_datosDomicilio(domicilio);
	_datosContacto(contacto);
	_datosLicencia(licencia);
	_datosConductor(conductor);
}

function _datosPersona(persona){
	$('#docu_perso').val(persona.docu_perso);
	$('#prim_nombr').val(persona.prim_nombr);$('#segu_nombr').val(persona.segu_nombr);
	$('#apel_pater').val(persona.apel_pater);$('#apel_mater').val(persona.apel_mater);
	$('#fech_nacim').val(persona.fech_nacim);$('#idde_nacio').val(persona.idde_nacio);
	$('#idde_ecivi').val(persona.idde_ecivi);
	if(persona.idde_gener === 1){
		$('#btnMasculino').button('toggle');
		$('#btnFemenino').button('reset');
	} else {
		$('#btnFemenino').button('toggle');
		$('#btnMasculino').button('reset');
	}
}

function _datosDomicilio(domicilio){
	$('#nomb_domic').val(domicilio.nomb_domic);$('#nume_domic').val(domicilio.nume_domic);
	$('#nomb_pobla').val(domicilio.nomb_pobla);$('#nume_bloqu').val(domicilio.nume_bloqu);$('#nume_depto').val(domicilio.nume_depto);
	$('#idde_provi').val(domicilio.idde_provi);
}

function _datosContacto(contacto){
	$('#tele_conta').val(contacto.tele_conta);$('#movi_conta').val(contacto.movi_conta);
	$('#mail_conta').val(contacto.mail_conta);
}

function _datosLicencia(licencia){
	$('#codi_licen').val(licencia.codi_licen);
	$('#fech_venci').val(licencia.fech_venci);

	if(licencia.A1 === true){$('#btnA1').button('toggle');}
	if(licencia.A2 === true){$('#btnA2').button('toggle');}
	if(licencia.A3 === true){$('#btnA3').button('toggle');}
	if(licencia.A4 === true){$('#btnA4').button('toggle');}
	if(licencia.A5 === true){$('#btnA5').button('toggle');}
	if(licencia.B === true){$('#btnB').button('toggle');}
	if(licencia.C === true){$('#btnC').button('toggle');}
	if(licencia.D === true){$('#btnD').button('toggle');}
	if(licencia.E === true){$('#btnE').button('toggle');}
	if(licencia.F === true){$('#btnF').button('toggle');}	
}

function _datosConductor(conductor){
	if(conductor.habilitado === 1){
		$('#btnHabilitado').button('toggle');
		$('#btnDesHabilitado').button('reset');
	} else {
		$('#btnDesHabilitado').button('toggle');
		$('#btnHabilitado').button('reset');
	}
}

/*INICIALIZAR MODAL*/
$(document).ready(function(){
  $('#modal_editar').on('hidden.bs.modal', function(){
  	_limpiarCamposLicencia();
  	_limpiarCamposConductor();
  });
});

function _limpiarCamposLicencia(){
	$('#codi_licen').val('');
	$('#fech_venci').val('');

	$('#btnA1').button('reset');
	$('#btnA2').button('reset');
	$('#btnA3').button('reset');
	$('#btnA4').button('reset');
	$('#btnA5').button('reset');
	$('#btnB').button('reset');
	$('#btnC').button('reset');
	$('#btnD').button('reset');
	$('#btnE').button('reset');
	$('#btnF').button('reset');
	/*
	$('#btnA1').attr('checked', false);$('#btnA1').removeClass('active');
	$('#btnA2').attr('checked', false);$('#btnA2').removeClass('active');
	$('#btnA3').attr('checked', false);$('#btnA3').removeClass('active');
	$('#btnA4').attr('checked', false);$('#btnA4').removeClass('active');
	$('#btnA5').attr('checked', false);$('#btnA5').removeClass('active');
	$('#btnB').attr('checked', false);$('#btnB').removeClass('active');
	$('#btnC').attr('checked', false);$('#btnC').removeClass('active');
	$('#btnD').attr('checked', false);$('#btnD').removeClass('active');
	$('#btnE').attr('checked', false);$('#btnE').removeClass('active');
	$('#btnF').attr('checked', false);$('#btnF').removeClass('active');
	*/
}

function _limpiarCamposConductor(){
	$('#codi_licen').val('');
	$('#fech_venci').val('');

	$('#btnA1').attr('checked', false);$('#btnA1').removeClass('active');
	$('#btnA2').attr('checked', false);$('#btnA2').removeClass('active');
	$('#btnA3').attr('checked', false);$('#btnA3').removeClass('active');
	$('#btnA4').attr('checked', false);$('#btnA4').removeClass('active');
	$('#btnA5').attr('checked', false);$('#btnA5').removeClass('active');
	$('#btnB').attr('checked', false);$('#btnB').removeClass('active');
	$('#btnC').attr('checked', false);$('#btnC').removeClass('active');
	$('#btnD').attr('checked', false);$('#btnD').removeClass('active');
	$('#btnE').attr('checked', false);$('#btnE').removeClass('active');
	$('#btnF').attr('checked', false);$('#btnF').removeClass('active');
}