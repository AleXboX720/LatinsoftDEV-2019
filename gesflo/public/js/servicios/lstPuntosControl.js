var lstPuntosControl = null;
/*###################################################################################################*/
function listarPuntosControlar(){
  var uri = 'listar/controles';
  
  var parametros = {"codi_circu" : codi_circuito};
    
  $.ajax({
    url: uri, 
    type: 'GET', 
    data: parametros, 
    dataType: 'json', 
    beforeSend: function(){},
    success: function(obj){
      var msg = 'Total de Puntos de Control: ' +obj.total;
      lstPuntosControl = obj.listado;
    },
    error: function(){
      console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
    }
  });
}
/*###################################################################################################*/