<?php

$sql="SELECT * FROM persona WHERE identifica='$_SESSION[usuario]'";
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);

$foto=$rw['foto'];

if ($foto=="") {
  $foto="img/perfil.png";
}

?>
<style type="text/css">
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 12px;
        text-align: center;
    }

</style>
<script type="text/javascript" language="javascript">
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
</script>
<script type="text/javascript">

                        
    function aceptar()
    {

bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
/*
var imagen = $('#imgSalida');

  imagen.removeAttr("width"); // quitamos el atributo width 
  imagen.removeAttr("height"); // quitamos el atributo height 
var ancho =imagen.width();
var alto = imagen.height()

if (alto =! ancho) 
  {
    bootbox.alert("Dimensiones de la imagen diferentes, deben ser iguales para una mayor calidad en escarapela");
                $("#error").html("Dimensiones de la imagen diferentes, deben ser iguales para una mayor calidad en escarapela");
               $("#existe").css({"display":"block","font-size":"200%"});
                $("#existe2").css({"display":"none","font-size":"200%"});
                return;
  }*/

$("#existe").css({"display":"none","font-size":"200%"});
$("#existe2").css({"display":"none","font-size":"200%"});


var formData = new FormData($(".formulario")[0]);
var message = "";  


        $.ajax({
            url: 'php_subir_archivos/upload_foto.php',  
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
                alerta(r.msg);
                $("#error").html(r.msg);
               $("#existe").css({"display":"block","font-size":"200%"});
                $("#existe2").css({"display":"none","font-size":"200%"});
            } else
            {
               
               alerta(r.msg);
               recargar_pagina(3000);
                //document.getElementById("prueba2").value=r.msg;

            }
             
              },
           
        });

     }

});      
    }


</script>
<div id="existe2" class="alert-box notice" style="display:none"><span>noticia: <img src="img/pb.gif"> </span>Subiendo datos...</div>
<div id="existe" class="alert-box error" style="display:none"><span>error: </span><p id="error"> </p></div>
<div id="existe3" class="alert-box success" style="display:none"><span>Exito: </span><p id="error2"> </p></div>

<style type="text/css">
    
    label,input
    {
        padding: 10px;
          border: none;
    }

td
{
    height: 30px;
}

</style>
<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" enctype="multipart/form-data" class="formulario">
        <table style="width:100%" border="0">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="4">Foto de perfil</th>
            </tr>
 

            <tr> 
                <td class="tdi">Tamaño</td>
                <td class="tdc">:</td>
                <td class="tdd">
                <label>Minimo 256x256</label>
                </td>   
                <td style="width:128px" rowspan="4"> <img style="border:none;width:128px;height:128px" src="<?php echo $foto ?>"></td>         
            </tr>

            <tr> 
                <td class="tdi">Peso</td>
                <td class="tdc">:</td>
                <td class="tdd">
                   <label>Maximo 1mb</label>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Formato</td>
                <td class="tdc">:</td>
                <td class="tdd">
                <label>PG,GIF,PNG</label>
                 </td>            
            </tr>

            <tr> 
                <td class="tdi">Archivo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                     <input   type="file" name="archivo" id="imagen" />
                </td>            
            </tr>


        </table>

    
        <div class="acciones">
		<input type="button" name="accion" value="Aceptar" onclick="aceptar()" />

        </div>

    </form>
</div>
<center>
<img id="imgSalida" width="80%" height="60%" src="" />
</center>