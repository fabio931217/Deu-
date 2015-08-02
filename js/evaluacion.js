function enviar()
{

var r = confirm("¿Desea Terminar?");
if (r == true)
{
  $.ajax({
            url:"evaluar.php",
            type: "POST",
            data:$('#contactform').serialize(),
            success: function(opciones){
             //  $('#Respuesta_calificacion').html(opciones);

              if(opciones=="Responder todas las preguntas"){alert(opciones);}
              else
              {
                
                $('#Respuesta_calificacion').html(opciones);

              }
              
            }
  })
return false;
}
else
{return false ;}



}

