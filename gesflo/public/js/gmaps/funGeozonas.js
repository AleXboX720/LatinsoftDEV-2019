var lstGeozonas = [];
var lstCoordenadas = [];
var laGeozona;

function crearGeozona(coordenadas){
    var laConfiguracion = _confiGeozona(coordenadas);
    laGeozona = new google.maps.Polygon(laConfiguracion);
    if(lstGeozonas.length > 0){
      eliminarGeozonas(lstGeozonas);
      lstGeozonas = [];
      lstGeozonas.lenght = 0;
    }

    lstGeozonas.push(laGeozona);
    cargarGeozonas(lstGeozonas);
}

function _confiGeozona(coordenadas){
  return {
    paths: coordenadas,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  };
}
function cargarGeozonas(listado){
  $.each(listado, function(i, obj){
    //listado[i].setMap(elMapa);
    obj.setMap(elMapa);
  });
}

function eliminarGeozonas(listado){
  $.each(listado, function(i, obj){
    obj.setMap(null);
  });
}