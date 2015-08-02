function reset () {
      $("#botonesCSS").attr("href", "css/mensajes.diseño.css");
      alertify.set({
        labels : {
          ok     : "Aceptar",
          cancel : "Cancelar"
        },
        delay : 5000,
        buttonReverse : false,
        buttonFocus   : "ok"
      });
    }


function alerta(mensaje)
{
	  alertify.alert(mensaje);
}
function confirmar(mensaje,callback)
{
	
  reset();
  alertify.set({ buttonReverse: true });

  alertify.confirm(mensaje, function (e) {
   if (e){


callback();


    
  }
  else {
          
          recargar_pagina(1000);
        }
   

  }
);

        

}