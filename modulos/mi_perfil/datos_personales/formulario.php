 <?php

$sql="SELECT * FROM persona WHERE identifica='$_SESSION[usuario]'";
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);

$documento=$_SESSION['usuario'];

$nombre=$rw['nombre'];
$apellido1=$rw['apellido1'];
$apellido2=$rw['apellido2'];
$direccion=$rw['direccion'];             

$fecha_nac=$rw['fechanaci']; 
$fecha_exp=$rw['fechaexp']; 

$sexo=$rw['sexo'];
$tipo_docu=$rw['tipoide'];
$muni_exp=$rw['municipioexp'];
$muni_naci=$rw['municipionaci'];
$muni_res=$rw['municipiores'];  

 $respuesta_secreta=Encrypter::decrypt($rw['respuesta']);
$pregunta_secreta=$rw['cod_pregunta'];   

?>
<script type="text/javascript">
                         
    function actualizar()
    {

confirmar("¿Desea guardar los datos?",continuar);


    }

function continuar()
 {

  $.post(page_root + "actualizar", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                alerta(r.msg);
            } else
            {
                 alerta("Datos actualizados");
                 recargar_pagina(4000);
            }
        });
}

</script>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">DOCUMENTO</th>
            </tr>
 

            <tr> 
                <td class="tdi">Tipo Identificacion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmidentificacion" name="cbmidentificacion" title="Tipo identificación" class="chosen-select" disabled="disabled">
                       
                        <?php
                        

      $rs=$db->query("SELECT codigo,nombre FROM tipoidentificacion"); 

        //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
 

       while ($row=$db->fetch_assoc($rs))
        {
          

          
          if ($row['codigo'] == $tipo_docu) 
          {
             echo " <option value='$row[codigo]' selected='selected'>$row[nombre]</option>";
          }
          else
          {
            echo " <option value='$row[codigo]'>$row[nombre]</option>";
          }
           
        } 
                     ?>

                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Identificacion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtidentificacion" id="txtidentificacion"  value="<?php echo $documento ?>" title="Identificacion" maxlength="30" disabled="disabled"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Fecha Expedicion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="fecha_exp" id="fecha_exp"  value="<?php echo $fecha_exp ?>" title="Fecha Expedicion" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Municipio Expedicion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                       <select id="muni_exp" name="muni_exp" title="Municipio Expedicion" class="chosen-select">
                       <?php
                        

         $rs=$db->query("SELECT m.id as codigo, CONCAT_WS (' : ', d.nombre ,m.nombre) as nombre FROM municipio m, departamento d WHERE m.departamento_id=d.id");
        //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
 

       while ($row=$db->fetch_assoc($rs))
        {
          

          
          if ($row['codigo'] == $muni_exp) 
          {
             echo " <option value='$row[codigo]' selected='selected'>$row[nombre]</option>";
          }
          else
          {
            echo " <option value='$row[codigo]'>$row[nombre]</option>";
          }
           
        } 
                     ?>
                    </select>
                </td>            
            </tr>                        

   <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">INFORMACION PERSONAL</th>
    </tr>                

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtnombre" id="txtnombre"  value="<?php echo $nombre ?>" title="Nombre" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Prime Apellido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtp1" id="txtp1"  value="<?php echo $apellido1 ?>" title="Prime Apellido" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Segundo Apellido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtp2" id="txtp2"  value="<?php echo $apellido2 ?>" title="Segundo Apellido" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Fecha de Nacimiento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="fecha_nac" id="fecha_nac"  value="<?php echo $fecha_nac ?>" title="Fecha de Nacimiento" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Sexo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmsexo" name="cbmsexo" title="Sexo" class="chosen-select">
                        <?php
                        

      $rs=$db->query("SELECT codigo,nombre FROM sexo"); 

        //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
 

       while ($row=$db->fetch_assoc($rs))
        {
          

          
          if ($row['codigo'] == $sexo) 
          {
             echo " <option value='$row[codigo]' selected='selected'>$row[nombre]</option>";
          }
          else
          {
            echo " <option value='$row[codigo]'>$row[nombre]</option>";
          }
           
        } 
                     ?>

                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Municipio Nacimiento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                          
               <select id="muni_naci" name="muni_naci" title="Municipio Nacimiento" class="chosen-select">
                         <?php
                        

      $rs=$db->query("SELECT m.id as codigo, CONCAT_WS (' : ', d.nombre ,m.nombre) as nombre FROM municipio m, departamento d WHERE m.departamento_id=d.id"); 

        //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
 

       while ($row=$db->fetch_assoc($rs))
        {
          

          
          if ($row['codigo'] == $muni_naci) 
          {
             echo " <option value='$row[codigo]' selected='selected'>$row[nombre]</option>";
          }
          else
          {
            echo " <option value='$row[codigo]'>$row[nombre]</option>";
          }
           
        } 
                     ?>
                    </select>
                </td>            
            </tr>                        
             <tr> 
                <td class="tdi">Municipio Residencia</td>
                <td class="tdc">:</td>
                <td class="tdd">
                   
               <select id="muni_res" name="muni_res" title="Municipio Residencia" class="chosen-select">
                         <?php
                        

        $rs=$db->query("SELECT m.id as codigo, CONCAT_WS (' : ', d.nombre ,m.nombre) as nombre FROM municipio m, departamento d WHERE m.departamento_id=d.id");
        //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
 

       while ($row=$db->fetch_assoc($rs))
        {
          

          
          if ($row['codigo'] == $muni_res) 
          {
             echo " <option value='$row[codigo]' selected='selected'>$row[nombre]</option>";
          }
          else
          {
            echo " <option value='$row[codigo]'>$row[nombre]</option>";
          }
           
        } 
                     ?>
                    </select>

                </td>            
            </tr>
             <tr> 
                <td class="tdi">Direccion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtdireccion" id="txtdireccion"  value="<?php echo $direccion ?>" title="Direccion" maxlength="30"/>
                </td>            
            </tr>               
 <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">INFORMACION DE RECUPERACION</th>
    </tr>  
<tr> 
                <td class="tdi">Pregunta secreta</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmprgunta" name="cbmpregunta" title="pregunta" class="chosen-select">
                        <?php
                          $rs=$db->query("SELECT id,nombre FROM preguntas_secretas"); 

        //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
 

       while ($row=$db->fetch_assoc($rs))
        {
          

          
          if ($row['id'] == $pregunta_secreta) 
          {
             echo " <option value='$row[id]' selected='selected'>$row[nombre]</option>";
          }
          else
          {
            echo " <option value='$row[id]'>$row[nombre]</option>";
          }
           
        } 
                        ?>
                    </select>
                </td>            
            </tr>        
  <tr>
                <td class="tdi">Respuesta</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text"  id="respuesta" name="respuesta" title="Respuesta" value="<?php echo $respuesta_secreta ?>" maxlength="29"/>  
                </td>
            </tr>              

        </table>

        
        <div class="acciones">
		<input type="button" name="accion" value="Actualizar" onclick="actualizar()" />

        </div>

    </form>
</div>
