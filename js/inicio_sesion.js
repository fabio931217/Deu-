function enviar()
{


var datos = $('#contactform').serialize();

$.ajax({
            url:"iniciar_sesion.php",
            type: "POST",
            data:datos,
            success: function(opciones){
               
               if(opciones=="ingreso")
    {
      location.href="inicio";
    }else{alert(opciones)}

            }
  })
return false;

}


