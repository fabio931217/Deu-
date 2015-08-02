<div class="ui-state-error ui-corner-all" style="padding: 0.3em;display:none" id="existe_delegado" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong>Error:</strong>  <p id="error_delegado"> </p>  </p>
 </div>
 <form id="frm_agregar_delegados">
 <table width="60%" align="center" border="0">
     
     <tr>

            <td width="73%">
          
            <input type="hidden" name="txtdelegadoid" id="txtdelegadoid" placeholder="Ingrese datos de usuario">

            <input type="text" name="txtdelegado" id="txtdelegado" placeholder="Ingrese datos de usuario">

            </td><td width="100"> <button  type="button" onclick="delegado_agregar()" >Agregar delegado</button></td>
                       
     </tr>

 </table>
</form>

 <form id="frmeliminar_delegado">
         <div class="holder3"></div>
             
                <table align="center" width="90%">


<tbody id="delegados-detalles">

  <?php

                    
                    $s="SELECT 
                    
                    d.codigo,
                    p.nombre,
                    p.apellido1,
                    p.apellido2
                    
                    FROM delegados d, general.persona p
                    WHERE 
                    d.acto='$acto_numero'
                    and p.identifica=d.usuario";
                    
                    $r=$db->query($s); //tomo la informacion de la base de datos
                   // echo $s;
                    
                    if ($db->num_rows($r)==0)
                    {
                   
                    echo"
                    <div class='ui-state-error ui-corner-all' style='padding: 0.7em;display:block' id='existe' >
                    <p ><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>
                    <strong>Advertencia:</strong>  No hay delegados para el acto: $_POST[txtbuscar]  </p>
                    </div>";
                    }
                    else
                    {
                    $n=0;
                    while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
                    
                    {
                    $n++;
                    
                   // echo $rw['codigo'];
                    $nombre2=$rw['nombre']." ".$rw['apellido1']." ".$rw['apellido2'];
                    
                    
                    echo "
                    <tr style='background-color:#004000;height:20px;text-align:center;padding:5px;color:#fff;'>
                    <td colspan=3' style='padding:5px;border-radius:6px'> Delegado numero: $n <input type='radio' style='float:right;height:15px;width:20px' value='$rw[codigo]' id='coddelegado' name='coddelegado'></td>                     
                    
                    </tr>
                    
                    </tr>
                    <tr>
                    <td>Delegado</td><td>:</td> <td><input type='text' name='txtdelegado' value='$nombre2'></td>                     
                    </tr>";
                    

}
}

?>
      
</tbody>

                </table>    
    
<div style="text-align:center; margin-top:10px;padding-top:30px; text-align:right; border-top:1px solid silver">
 
  <button  type="button" onclick="delegado_eliminar()" >Eliminar delegado</button>
     
</div>

 </form>

       <script type="text/javascript">

                      
                    function delegado_agregar()
                    {

                                bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{

                   //alert("hola");
                    $.post(page_root + "agregar_delegado", $("#frm_agregar_delegados").values(), function(data) {
                   // alert(data);
                    var r = jQuery.parseJSON(data);
                    if (r.msg==1) 
                        {
                            bootbox.alert("Agregado con exito");
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
                    
                    function delegado_eliminar()
                    {

                               bootbox.confirm("¿Desea eliminar los datos?", function(result) {

if (result==true) 
{

                     var dele_id=($('input:radio[name=coddelegado]:checked').val());
                 

                   $.post(page_root + "eliminar_delegado","id="+ dele_id, function(data) {
              
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

<script type="text/javascript">
  $(document).ready(function(e) {

            $("#txtdelegado").autocompletar2(page_root + "listarPersonas2", {
            form: "formulario2",
            inputId: "txtdelegadoid",
            minLength: 3}); 

        
    });
</script>
