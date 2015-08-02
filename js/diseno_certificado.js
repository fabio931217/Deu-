
$(window).load(function(){

$(".ocultar").hide();
 $(function() {
  $('#imagen').change(function(e) {
      addImage(e); 
     });

     function addImage(e){
      var file = e.target.files[0],
      imageType = /image.*/;
    
      if (!file.type.match(imageType))
       return;
  
      var reader = new FileReader();
      reader.onload = fileOnload;
      reader.readAsDataURL(file);
     }
  
     function fileOnload(e) {
      var result=e.target.result;
      $('#imgSalida').attr("src",result);
     }
    });
  });

 

function cambiar_diseño()
{
    //alert("Hoa");
    var tipo = document.getElementById("cbmtipodiseno").value;
    //alert(tipo);
    if (tipo==2) 
        {
            $(".ocultar").show();
              var result="";
            $('#imgSalida').attr("src",result);
        }
        else
            {
                  $(".ocultar").hide();
                  var result="img\\predeterminado.jpg";
                   $('#imgSalida').attr("src",result);
            }

        }

    function cargarEventos()
 {

       
        cargarCombo(page_root + "cargarEventos", "formulario", "cbmevento", true);

        //setTimeout (" autocomplete()", 1000);

  
 }
                        
    function aceptar()
    {

bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{


$("#existe").css({"display":"none","font-size":"200%"});
$("#existe2").css({"display":"none","font-size":"200%"});


var formData = new FormData($(".formulario")[0]);
var message = "";  


        $.ajax({
            url: 'upload.php',  
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            
            beforeSend: function(){
                 $("#existe2").css({"display":"block","font-size":"200%"});
            },
            //una vez finalizado correctamente
            success: function(data){
//alert(data);
              var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                

                if (r.msg=="Este acto ya tiene un diseño para este objeto y funcion.")
 {
bootbox.confirm("Este acto ya tiene un diseño para este objeto y funcion. <br/> ¿Desea actualizar los datos?", function(result) {

if (result==true) 
{
     
 actualizar();

}
else
 {
                $("#error").html(r.msg);
               $("#existe").css({"display":"block","font-size":"200%"});
                $("#existe2").css({"display":"none","font-size":"200%"});
 }


});

 }else
 {
  bootbox.alert(r.msg);
                $("#error").html(r.msg);
               $("#existe").css({"display":"block","font-size":"200%"});
                $("#existe2").css({"display":"none","font-size":"200%"});
 }


            } else
            {
               
               bootbox.alert(r.msg);
               recargar_pagina(3000);
                //document.getElementById("prueba2").value=r.msg;

            }
             
              },
           
        });

     }

});      
    }

function actualizar()
    {






$("#existe").css({"display":"none","font-size":"200%"});
$("#existe2").css({"display":"none","font-size":"200%"});


var formData = new FormData($(".formulario")[0]);
var message = "";  


        $.ajax({
            url: 'upload_actualizar.php',  
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            
            beforeSend: function(){
                 $("#existe2").css({"display":"block","font-size":"200%"});
            },
            //una vez finalizado correctamente
            success: function(data){
//alert(data);
              var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
if (r.msg=="Este acto ya tiene un diseño para este objeto y funcion.") {$("#actualizar").css({"display":"block","font-size":"200%"});};

                bootbox.alert(r.msg);
                $("#error").html(r.msg);
               $("#existe").css({"display":"block","font-size":"200%"});
                $("#existe2").css({"display":"none","font-size":"200%"});


            } else
            {
               
               bootbox.alert(r.msg);
               recargar_pagina(3000);
                //document.getElementById("prueba2").value=r.msg;

            }
             
              },
           
        });

     

      
    }
