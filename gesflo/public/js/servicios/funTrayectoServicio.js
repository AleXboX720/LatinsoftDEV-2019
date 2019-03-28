var objInformeServicio = null;
var lstEventos = [];
var lstRutas = [];
var lstMoviles = [];

var lstMarkers = [];
var lstBurbujas = [];

var viajeDetenido;

$(document).ready(function(){
  $('.btnIda').click(function(){
    var sent_exped = 0;
    var clr = '#FF0000';
    _crearRuta(sent_exped, clr);
  });
});

$(document).ready(function(){
  $('.btnRegreso').click(function(){
    var sent_exped = 1;
    var clr = '#0000FF';
    _crearRuta(sent_exped, clr);
  });
});

function _crearRuta(codi_senti, clr){
  limpiarListados();
  //var expediciones = objInformeServicio.expediciones;
  //var codi_equip = objInformeServicio.servicio[0].codi_equip;

  var mi_servicio = objInformeServicio.mi_servicio;
  var servicio = mi_servicio.servicio;
  var expediciones = mi_servicio.expediciones;
  var codi_equip = servicio.codi_equip;

  $.each(expediciones, function(i, obj){
    if(obj.codi_senti == codi_senti){
      var desde = new Date(obj.inic_exped).getTime()/1000;
      var hasta = new Date(obj.term_exped).getTime()/1000;
      var url = definirUrl(codi_equip, desde, hasta);

      listarEventos(url, clr, codi_equip);
      if(lstRutas.length > 0){
        _agregarRutas();
      }
    }
  });
}

function _definirRuta(listado, clr, codi_equip){
  var confiRuta = configurarRutaXXX(listado, clr);
  var laRuta = new google.maps.Polyline(confiRuta);
  
  //lstRutas[codi_equip] = laRuta;
  lstRutas.push(laRuta);
}

function configurarRutaXXX(listado, clr){
  return {
    map: elMapa,
    path: listado,
    clickable: true,
    draggable: false,
    editable: false,
    geodesic: true,
    strokeColor: clr,
    strokeOpacity: 7.9,
    strokeWeight: 5.8,
    //fillColor: '#000000',
    fillOpacity: 0.35,
    visible: true
  };
}

function definirUrl(d, i, f){
  return 'http://localhost/api/trackers/tpublico/antofagasta/linea104/trayectoTracker?idde_devic=' +d+ '&inicio=' +i+ '&fin=' +f;
  //return 'http://www.latinsoft.cl/api/trackers/tpublico/antofagasta/linea104/trayectoTracker?idde_devic=' +d+ '&inicio=' +i+ '&fin=' +f;
}

function listarEventos(url, clr, codi_equip){
  //var mensajeCargando = $('#divCargando');

  $.ajax({
    url: url,
    type: 'POST',
    dataType:'json'
  })
  .done(function(data, textStatus, jqXHR ){
    if(eventosJSON_OK(data.Error)){
      $('#btnRango').removeClass('hidden');
      lstEventos = data['Moviles'][0]['Eventos'];

      if(lstEventos.length > 0){
        var lstCoordenadas = [];
        var bounds = new google.maps.LatLngBounds();
        $.each(lstEventos, function(i, evento){
          var pos = new google.maps.LatLng(evento.Latitud, evento.Longitud);
          lstCoordenadas.push(pos);
          bounds.extend(pos);
        });

        $("#btnRango").attr("min", 0);
        $("#btnRango").attr("max", lstCoordenadas.length - 1);
        _definirRuta(lstCoordenadas, clr, codi_equip);
        elMapa.fitBounds(bounds);
      }
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

function eventosJSON_OK(mensaje){
  var elEstado = false;
  switch(mensaje){
    case 'Invalid authorization':
      console.log("USUARIO INVALIDO...!!!");
      break;
    case 'No devices specified (invalid group?)':
      console.log("GRUPO INVALIDO o NO HAY MOVILES...!!!");
      break;
    case 'Internal error (account)':
      console.log("PROBLEMAS EN EL SERVIDOR...!!!");
      break;
    default: 
      elEstado = true;
      break;
  }
  return elEstado;
}

function _agregarRutas(){
  var listado = lstRutas;
  $.each(listado, function(i, obj){
    obj.setMap(elMapa);
  });
}

function _agregarMarkers(){
  var listado = lstMarkers;
  $.each(listado, function(i, obj){
    //ultimaPosicion = obj.getPosition();
    obj.setMap(elMapa);
  });
}

function _limpiarMarkers(){
  var listado = lstMarkers;
  $.each(listado, function(i, obj){
    obj.setMap(null);
  });
  lstMarkers = [];
}

function _agregarBurbujas(){
  var listado = lstBurbujas;
  $.each(listado, function(i, obj){
    //ultimaPosicion = obj.getPosition();
    obj.close();
    obj.setMap(elMapa);
  });
}

function _limpiarBurbujas(){
  var listado = lstBurbujas;
  $.each(listado, function(i, obj){
    obj.setMap(null);
  });
  lstBurbujas = [];
}

function _cerrarBurbujas(){
    var listado = lstBurbujas;
    $.each(listado, function(i, obj){
      obj.close();
    });
}

function _limpiarRutas(){
  var listado = lstRutas;
  $.each(listado, function(i, obj){
    obj.setMap(null);
  });
  lstRutas = [];
}

function limpiarListados(){
  lstEventos.length = 0;
  lstEventos = [];
  _limpiarRutas();
  _limpiarMarkers();
  _limpiarBurbujas();
}


/*RECORRER LA RUTA CON UN MARKER*/
$(document).ready(function(){
  $('.btnPlay').click(function(){
    if(lstEventos.length > 0){
      iniciarRecorrido(lstEventos);
      viajeDetenido = false;
    }

  });
});

$(document).ready(function(){
  $('#btnRango').on('change',function(){
    var valor = $('#btnRango').val();
    _limpiarMarkers();
    _cerrarBurbujas();
    _limpiarBurbujas();
    var elMarker = null;
    var laBurbuja = null;
    var pos = new google.maps.LatLng(lstEventos[valor].Latitud, lstEventos[valor].Longitud);
    var grd = _getGradoMarker(parseInt(lstEventos[valor].Heading));
    var spd = parseInt(lstEventos[valor].Velocidad);
    var clr = _getColorMarker(spd);


    var ultimaPosicion = null;
    var laConfig = configurarMarker(pos, grd, spd, clr, 'movil');
    elMarker = new google.maps.Marker(laConfig);
    laBurbuja = new google.maps.InfoWindow();

    //elMarker.setMap(elMapa);
    lstMarkers.push(elMarker);
    lstBurbujas.push(laBurbuja);

    _agregarMarkers();      
    _agregarBurbujas();
    cambiarZoom(15);

    centrarMapa(elMarker);
    actualizarBurbuja(elMarker, laBurbuja, spd);
    laBurbuja.open(elMapa, elMarker);

    //console.clear();
    //console.dir(lstEventos[valor]);
    //$('#tiempo').html('GRADOS: '+ lstEventos[valor].Heading);
    $('#tiempo').html('HORA: '+ lstEventos[valor].Hora);
    

  });
});

function iniciarRecorrido(listado){
  _limpiarMarkers();
  _cerrarBurbujas();
  _limpiarBurbujas();
  var elMarker = null;
  var laBurbuja = null;
  $.each(listado, function(i, obj){
    var pos = new google.maps.LatLng(obj.Latitud, obj.Longitud);
    var grd = _getGradoMarker(parseInt(obj.Heading));
    var spd = parseInt(obj.Velocidad);
    var clr = _getColorMarker(spd);


    var ultimaPosicion = null;
    if(i == 0){
      var laConfig = configurarMarker(pos, grd, spd, clr, 'movil');
      elMarker = new google.maps.Marker(laConfig);
      laBurbuja = new google.maps.InfoWindow();

      //elMarker.setMap(elMapa);
      lstMarkers.push(elMarker);
      lstBurbujas.push(laBurbuja);

      _agregarMarkers();      
      _agregarBurbujas();
      cambiarZoom(15);
    }
    

    ultimaPosicion = elMarker.getPosition();
      window.setTimeout(function(){
        //if(viajeDetenido == false){
          if (!pos.equals(ultimaPosicion))
          {
            actualizarMarker(elMarker, laBurbuja, pos, grd, spd, clr);
          }
        //}
      }, 987 * i);
  });
}

function actualizarMarker(marker, laBurbuja, pos, grd, spd, clr){
    marker.setIcon(_configurarIcono(grd, spd, clr));
    marker.setPosition(pos);
    elMapa.panTo(pos);
    
    actualizarBurbuja(marker, laBurbuja, spd)
}

function actualizarBurbuja(marker, laBurbuja, spd){
    laBurbuja.close(elMapa, marker);
    if(spd == 0){
       laBurbuja.setContent('<small style="color:#000;">[DETENIDO]</small>');
    } else {
       laBurbuja.setContent('<b>Velocidad </b><small style="color:#000;">['+ spd +' km/hrs]</small>');
    }
    laBurbuja.open(elMapa, marker);
}