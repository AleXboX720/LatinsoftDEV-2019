var objServicio = null;

function guardarServicio(){
	objServicio = _definirServicio();
  var obj = objServicio.servicio;

  var existe = existeServicio(obj.codi_circu, obj.codi_servi);

  existe.done(function(data, textStatus, jqXHR){
    if(data.existe){
      var title = 'Atencion';
      toastr.error(data.msg, title);
      $('#hora_servi').focus();
      
      return;
    } else {
      var pendientes = serviciosPendientes(obj.codi_circu, obj.nume_movil, obj.pate_movil);
      pendientes.done(function(data, textStatus, jqXHR){
        //console.dir(data);
        if(data.pendientes){
          var title = 'Nota';
          toastr.warning(data.msg, title);
          $('#nume_movil').focus();
          
          return;
        } else {
          crearServicio(objServicio);
          if($('#impr_servi').prop('checked')){
            setTimeout(function(){
              var busqueda = buscandoServicio(obj.codi_circu, obj.nume_movil, obj.pate_movil, obj.codi_servi);
              busqueda.done(function(data, textStatus, jqXHR){
                imprimirServicio(data.servicio, data.controladas); 
              });   
            }, 3000);
          }
          limpiarCampos();
        }
      });      
    }
  }); 
}

function _definirServicio(){
	var fecha_servicio = new Date($('#fech_servi').val() +' '+ $('#hora_servi').val());
  var timestamp = Math.floor(fecha_servicio.getTime()/1000);//FORMATO TIMESTAMP

  var lstProgramadas = [];
  var minu_contr = 0;
  var regr_servi = 0;
  var inic_servi = timestamp;
  var term_servi = null;
  var codi_servi = timestamp;
  var codi_circu = parseInt($('#codi_circu').val());
  var codi_licen = parseInt($('#codi_licen').val());
  var docu_perso = parseInt($('#docu_perso').val());
  var pate_movil = $('#pate_movil').val();
  var codi_equip = parseInt($('#codi_equip').val());
  var fech_servi = $('#fech_servi').val();
  var hora_servi = $('#hora_servi').val();

  var docu_empre = 96711420;
  

  var expediciones = null;
  var expedicionPlus = false;

  var ulti_contr = 0;
  $.each(lstPuntosControl, function(i, obj){
    minu_contr += Math.round(obj.minu_contr * 60);
    obj.fech_progr = codi_servi + minu_contr;
    obj.fecha = new Date(obj.fech_progr * 1000).toISOString().slice(0,10);
    obj.hora = new Date(obj.fech_progr * 1000).toLocaleTimeString().slice(0,5);
    obj.codi_servi = codi_servi;
		obj.nume_movil = objMovil.nume_movil;
    lstProgramadas.push(obj);

    if(obj.codi_senti == 1 && regr_servi == 0){
      expedicionPlus = true;
      regr_servi = codi_servi + minu_contr;
    }
    ulti_contr = codi_servi + minu_contr;
  });

  return {
    'movil' : objMovil,
    'conductor' : objConductor, 
    'servicio' : 
    {
      'fech_servi' : fech_servi,
      'hora_servi' : hora_servi,
      'codi_servi' : codi_servi,
      'nume_movil' : objMovil.nume_movil, 
      'docu_perso' : docu_perso,
      'codi_circu' : codi_circu,
      'codi_licen' : codi_licen,
      'docu_empre' : docu_empre,
      'pate_movil' : pate_movil,
      'codi_equip' : codi_equip,
      'inic_servi' : inic_servi,
      'term_servi' : ulti_contr,
      'habilitado' : 1,
    },
    'programadas' : lstProgramadas
  };
}