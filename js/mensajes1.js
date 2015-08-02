

var myVar;

function alerta(mensaje)
{
	 bootbox.alert(mensaje);
}

function confirmar(mensaje,callback)
{


	bootbox.confirm(mensaje, function(result) {


if (result==false) 
{
      
  return;

}
else
{
callback();

	
}	
  
});

 
}
