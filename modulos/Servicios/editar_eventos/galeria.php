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

<script type="text/javascript">
 
              
    function aceptar_archivo()
    {

bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{


$("#existe").css({"display":"none","font-size":"200%"});
$("#existe2").css({"display":"none","font-size":"200%"});


var formData = new FormData($(".formulario_archivo")[0]);
var message = "";  


        $.ajax({
            url: 'upload_galeria.php',  
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

});      
    }

                  function galeria_eliminar()
                    {

                               bootbox.confirm("¿Desea eliminar los datos?", function(result) {

if (result==true) 
{

                     var dele_id=($('input:radio[name=codgaleria]:checked').val());
                 

                   $.post(page_root + "eliminar_galeria","id="+ dele_id, function(data) {
              
                 var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                            bootbox.alert("Eliminado con exito");
                            recargar_pagina(3000);
                        }
                        else
                        {
                    bootbox.alert(r.msg);
                     $("#error_delegado").html(r.msg);
                     $("#existe_delegado").css({"display":"block","font-size":"200%"});
                        }
                    });
}

});
                    }
    
</script>

<div class='ui-state-highlight ui-corner-all' style="padding: 0.7em;display:block">
            <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                <strong>Informacion:</strong>  <ol>
                    <li>Subir 5 imagenes en total para lograr visualizar correctamente.</li>
                    </ol>  </p>
</div>
<br/>
 <center><div class="messages" style="padding: 0 .7em;display:none" id="existe2"> <img src="img/pb.gif"> Subiendo datos...</div></center>
<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;display:none" id="existe" >
            <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Advertencia:</strong> <p id="error"> </p>  </p>
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario_archivo" enctype="multipart/form-data" class="formulario_archivo">
        <table style="width:100%">

                       
            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Subir Fotos</th>
            </tr>

            <tr> 
                <td class="tdi">Archivo</td>
                <td class="tdc">:</td>
                <td class="tdd">


                <input type="hidden" name="proyectoId" id="proyectoId"  value='<?php echo $acto_numero ?>'
                           class="no-modificable" title="Buscar">

                   <input   type="file" name="archivo" id="imagen" />
                 <!--  <input  type ="text" name="prueba" id="prueba2" /> -->
                </td>            
            </tr>

          <tr> 
                <td class="tdi">Descripcion</td>
                <td class="tdc">:</td>
                <td class="tdd">

              <textarea id="descripcion" name="descripcion" style="width:100%;height:100px" value=""></textarea>
                 <!--  <input  type ="text" name="prueba" id="prueba2" /> -->
                </td>            
            </tr>

        </table>

        
        <div class="acciones">
        <input type="button" name="accion" value="Aceptar" onclick="aceptar_archivo()" class="accion-aceptar" />

        </div>

    </form>
</div>

<br/>
<div class="holder"></div> 
<form  id="certificar"  method="POST" method="post"  target="_blank" 
        action="<?php echo PAGE_ROOT . "mostrar" ?>">


 <table width="98%"  id="reporte" name="reporte" align="center" style="margin-bottom:30px;border-radius:12px " class="bordered">
  <thead>
        <thead>
        <tr>
            <th width="15px" style="border-radius:8px 0px 0px 8px;color:#000">Seleccione</th>
            <th style="color:#000">Imagen</th>
            <th style="color:#000">Descripcion</th>
            <th style="border-radius: 0px 8px 8px 0px;width:5px;color:#000">Descargar</th>
        </tr>
  </thead>
        <tbody id="cuerpo-detalles">
       
 <?php



$s="SELECT * FROM galeria WHERE cod_evento='$acto_numero'";

//echo $s;
$r=$db->query($s);

while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
        {
               
echo "<tr onclick='prueba(this)' style='cursor:pointer;'>
            <td> <center> <input type='radio' id='codgaleria' name='codgaleria' value='$rw[id]'> </center> </td>

            <td><center> <img  src='$rw[imagen_grande]' style='float:left;width:200px'> </img> </center> </td>

            <td> $rw[descripcion] </td>
            <td width='20px'> <a href='$rw[imagen_grande]' target='_blank'> <button type='button'> <div></div> Descargar <button> </a></td>
          
        </tr> ";

        } 

   ?>
   
        
        
        </tbody>     
  </table>
  
  <div class="acciones">
        <input type="button" name="accion" value="Eliminar Archivo" onclick="galeria_eliminar()" class="accion-aceptar" />

        </div>

</form>


