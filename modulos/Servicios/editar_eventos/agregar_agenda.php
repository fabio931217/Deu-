 <div class="ui-state-error ui-corner-all" style="padding: 0.2em;display:none" id="existe_ag" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong>Error:</strong>  <p id="error_ag"> </p>  </p>
 </div>
 <form id="frmagregar_agenda">
   
<input type="hidden" value="" name="id">       
               

<table align="center" width="90%">


<tbody>

<tr style='background-color:#004000;height:20px;text-align:center;padding:5px;color:#fff;'>
                    
                   
                   <td colspan='3' style='padding:5px;border-radius:6px'> Agregar agenda</td>                     
                
</tr>
               
 <tr>

                    <td>Fecha</td><td>:</td> <td><input type='date' name='txtfecha'></td>                     
</tr>

<tr>
                    
                    <td>Hora inicio</td><td>:</td> <td>

                    <select name='hora_inicio'>

 <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?>
                    </select>
                    </td>                     

</tr>
                  
<tr>
                    
                    <td>Hora termina</td><td>:</td> <td>

                    <select name='hora_termina'>
 <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?>


                    </select>
                    </td>                     
</tr>
<tr>
                    <td>Exponente</td><td>:</td> <td>
<input type='hidden' name='txtexponenteId' id="txtexponenteId" class="usuarios">
                    <input type='text' name='txtexponente' id="txtexponente" class="usuarios"></td>                     
</tr>

<tr>
                    <td>Tema</td><td>:</td> <td><input type='text' name='txttema' ></td>                     
</tr>

<tr>
                    <td>Cupos</td><td>:</td> <td><input type='text' class="numeros" name='txtcupos' paceholder='0 es ilimitado' ></td>                     
</tr>

<tr>
                    <td>Escenario</td><td>:</td> <td>

                    <select name='cbmescenario'>
                    <?php
              llenar_combo2("SELECT id as codigo, nombre FROM escenario WHERE estado_id='1'",true);
              ?> 
                    </select>

                </td>                     
</tr>
                 

</tbody>

                </table>    
    
<div style="text-align:center; margin-top:10px;padding-top:30px; text-align:right; border-top:1px solid silver;">

  <button  type="button" onclick="agenda_agregar()" >Guardar agenda</button>
  <button  type="button" onclick="ocultar()" >Cancelar</button>
    
</div>

       </form>
 

 <script type="text/javascript">

function ocultar() 
{
  $("#dialogo").hide();
}


 </script>
  
  
<script type="text/javascript">
  $(document).ready(function(e) {
    
            $("#txtexponente").autocompletar2(page_root + "listarPersonas", {
            form: "rmagregar_agenda",
            inputId: "txtexponenteId",
            minLength: 3}); 

        
    });

   function agenda_agregar()
                    {
                   
                    bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
                    $.post(page_root + "guardar_agenda", $("#frmagregar_agenda").values(), function(data) {
                    //alert(data);
                    var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                            bootbox.alert("Agregada con exito");
                            recargar_pagina(4000);
                        }
                        else
                        {
                    bootbox.alert(r.msg);
                     $("#error_ag").html(r.msg);
                     $("#existe_ag").css({"display":"block","font-size":"200%"});
                        }
                    });


}

});
                    }
</script>