var lstPuntosControl = null;
/*###################################################################################################*/
function detallarControlesCircuito(){
  var uri = 'detallar/circuito';
  
  var parametros = {"codi_circu" : codi_circuito};
  var token = document.getElementsByName("_token");
  $.ajax({
    url: uri, 
    headers : {'X-CSRF-TOKEN' : token[0].value},
    type: 'POST', 
    data: parametros, 
    dataType: 'json', 
    beforeSend: function(){},
    success: function(obj){
      lstPuntosControl = obj.listado;
    },
    error: function(){
      console.log('Lamentablemente Hay un Error de Coneccion, Intentelo Mas Tarde!!!');
    }
  });
}
/*###################################################################################################*/