<div class="ui-state-error ui-corner-all" style="padding: 0.3em;display:none" id="existe_organizador" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong>Error:</strong>  <p id="error_organizador"> </p>  </p>
 </div>
<form id="frmagregarorganizador" method="POST">
 <div style="min-height:300px">

 <table width="90%" align="center">
 <tr>
   <th>Dependencia</th>
   <th>Organizadores</th>
   <th>Funcion</th>
   <th></th>

 </tr>
   
   <tr>
            <td width="170px"> 

      <select id="cbmdependencia" name="cbmdependencia" class="chosen-select">
  <?php 
              llenar_combo("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre",true)
              ?>

      </select> 

            </td>
            <td>
            <input type="hidden" name="txtorganizadoresid" id="txtorganizadoresid" placeholder="Ingrese datos de usuario">
            
            <input type="text" name="txtorganizadores" id="txtorganizadores" placeholder="Ingrese datos de usuario"></td>
            
            <td width="120px"><select id="cbmfunciones" name="cbmfunciones" class="chosen-select" >
 <?php
              llenar_combo("SELECT * FROM Funcion",true);
              ?>

            </select></td>
            <td width="150px"> <button  type="button" onclick="organizador_agregar()" >Agregar organizador</button></td>
           
          </tr>
 </table>
</form>
 <form id="frmeliminar_organizador">
         <div class="holder"></div>
                <table align="center" width="90%">


<tbody id="cuerpo-detalles">

                       <?php
                       
                       
                       $s="SELECT 
                       o.*,
                       p.nombre,
                       p.apellido1,
                       p.apellido2
                       
                       FROM organizador o, general.persona p,funcion f,dependencia d
                       WHERE 
                       o.acto_id='$acto_numero'
                       and p.id=o.persona_id
                       and o.funcion_id=f.codigo
                       and o.dependencia_id=d.id";
                       
                       $r=$db->query($s); //tomo la informacion de la base de datos
                       //echo $s;
                       $n=0;
                       while ($rw2=$db->fetch_assoc($r))
                       {
                       $n++;
                                            
                       $nombre2=$rw2['nombre']." ".$rw2['apellido1']." ".$rw2['apellido2'];
                     
                       
                       echo "
                       <tr style='background-color:#004000;height:20px;text-align:center;padding:5px;color:#fff;'>
                       <td colspan=3' style='padding:5px;border-radius:6px'> Organizador numero: $n <input type='radio' style='float:right;height:15px;width:20px' value='$rw2[id]' id='codorganizador' name='codorganizador'></td>                     
                       
                       </tr>
                       
                       </tr>
                       <tr>
                       <td>Organizador</td><td>:</td> <td><input type='text' name='txtexponente' value='$nombre2'></td>                     
                       </tr>
                       
                       <tr>
                       <td>Dependencia</td><td>:</td> <td><select>";
                       
                       $r1=$db->query("SELECT d.nombre,d.id,i.nombre as institucion from dependencia d,institucion i WHERE i.codigo=d.institucion_id ORDER BY institucion"); 
                       
                       //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
                       
                       
                       while ($row=$db->fetch_assoc($r1))
                       {
                       
                       
                       
                       if ($row['id'] == $rw2['dependencia_id']) 
                       {
                       echo " <option value='$row[id]' selected='selected'>$row[institucion]-$row[nombre]</option>";
                       }
                       else
                       {
                       echo " <option value='$row[id]'>$row[institucion]-$row[nombre]</option>";
                       }
                       
                       } 
                       
                       
                       echo"</select></td>                     
                       </tr>
                       <tr>
                       <td>Funcion</td><td>:</td> <td><select>";
                       
                       $r1=$db->query("SELECT * from funcion"); 
                       
                       //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
                       
                       
                       while ($row=$db->fetch_assoc($r1))
                       {
                       
                       
                       
                       if ($row['codigo'] == $rw2['funcion_id']) 
                       {
                       echo " <option value='$row[codigo]' selected='selected'>$row[nombre]</option>";
                       }
                       else
                       {
                       echo " <option value='$row[codigo]'>$row[nombre]</option>";
                       }
                       
                       } 
                       
                       
                       }
                      
                       ?>
    
      





</tbody>

                </table>    
  
<div style="text-align:center; margin-top:10px;padding-top:30px; text-align:right; border-top:1px solid silver">
 
  <button  type="button" onclick="organizador_eliminar()"  >Eliminar organizador</button>
     
</div>

</form>

</div>
  
<script type="text/javascript">
  $(document).ready(function(e) {
    
            $("#txtorganizadores").autocompletar2(page_root + "listarPersonas", {
            form: "frmagregarorganizador",
            inputId: "txtorganizadoresid",
            minLength: 3}); 

        
    });
</script>

<script type="text/javascript">
                    
                 
                 function organizador_agregar()
                    {
                   
                           bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{

                    $.post(page_root + "agregar_organizador", $("#frmagregarorganizador").values(), function(data) {
                   //alert(data);
                    var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                            bootbox.alert("Agregado con exito");
                            recargar_pagina(3000);
                        }
                        else
                        {
                    bootbox.alert(r.msg);
                     $("#error_organizador").html(r.msg);
                     $("#existe_organizador").css({"display":"block","font-size":"200%"});
                       }

                    });

}

});
                    }

                    
                    
                    function organizador_eliminar()
                    {

        bootbox.confirm("¿Desea eliminar los datos?", function(result) {

if (result==true) 
{

                     var orga_id=($('input:radio[name=codorganizador]:checked').val());
                 

                   $.post(page_root + "eliminar_organizador","id="+ orga_id, function(data) {
               
                 var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                            bootbox.alert("Eliminado con exito");
                            recargar_pagina(3000);
                        }
                        else
                        {
                    bootbox.alert(r.msg);
                     $("#error_organizador").html(r.msg);
                     $("#existe_organizador").css({"display":"block","font-size":"200%"});
                        }
                    });

  }

});
                    }
    
                 
                    </script>