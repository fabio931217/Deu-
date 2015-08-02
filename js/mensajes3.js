function alerta(mensaje)
{
	swal("Informacion", mensaje, "success")
}

function confirmar(mensaje,callback)
{
	
  swal({  
  title: "Informacion",
  text: mensaje, 
  type: "warning", 
  showCancelButton: true,
  confirmButtonColor: "#004000",  
  confirmButtonText: "Aceptar", 
   closeOnConfirm: false }, 

  	function(){  
callback();


  	});
        

}