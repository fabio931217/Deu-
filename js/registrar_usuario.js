function enviar()
{

var r = confirm("¿Desea Guardar?");
if (r == true)
{
  $.ajax({
            url:"registrar.php",
            type: "POST",
            data:$('#contactform').serialize(),
            success: function(opciones){
              alert(opciones);

              if(opciones=="Los datos se guardaron correctamente"){location.reload();}
              
            }
  })
return false;
}
else
{return false ;}



}

