<div class="ui-state-error ui-corner-all" style="padding: 0.3em;display:none" id="existe_agenda" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong>Error:</strong>  <p id="error_agenda"> </p>  </p>
 </div>
                     <form id="frmmodificar_agenda">
                     <input type="hidden" value="<?php echo $id ?>" name="id">
                     <div class="holder2"></div>
                     
                     <table align="center" width="90%">
                     
                     
                     <tbody id="agenda-detalles">
                     <?php
                     
                     @$id =$_POST['eventoId'];
                     $s="SELECT 
                     a.id as codigo,
                     a.fecha,
                     a.tema,
                     a.cupos,
                     a.h_inicia,
                     a.h_termina,
                     
                     p.nombre,
                     p.apellido1,
                     p.apellido2,
                     
                     e.nombre as escenario,
                     e.ubicacion as ubicacion
                     
                     
                     FROM agenda a, general.persona p, escenario e
                     
                     WHERE 
                     a.acto_id='$id'
                     and p.id=a.exponente
                     and a.escenario_id=e.id
                     ORDER BY codigo ASC";
                     
                     //$db = $this->db;
                     $r = $db->query($s);       
                     //echo $s;
                     
                     while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
                     
                     {
                     
                     
                     $Fecha=$rw['fecha'];
                     
                     $r2=$db->query("SELECT * from horas");
                     
                     while ($rw2=$db->fetch_assoc($r2) /* paso los datos de $r a $rt (rtable) */)
                     {
                     
                     if ($rw2['id']==$rw['h_inicia'])
                     {
                     $inicia=$rw2['conversion'];
                     }
                     if ($rw2['id']==$rw['h_termina'])
                     {
                     $fin=$rw2['conversion'];
                     }
                     
                     }
                     /*
                     echo $fin;
                     echo $inicia;
                     */
                     $escenario=$rw['escenario'];
                     $ubicacion =$rw['ubicacion'];
                     $cupos =$rw['cupos'];
                     if ($cupos==0) {
                            $cupos="ILimitados";
                     }

                     $nom2=$rw['nombre']." ".$rw['apellido1']." ".$rw['apellido2'];
                     $nombre2= strtoupper($nom2);
                     $tema=$rw['tema'];
                     
                     echo "
                     <tr style='background-color:#004000;height:20px;text-align:center;padding:5px;color:#fff;'>
                     <td colspan='3' style='padding:5px;border-radius:6px'> Agenda numero: $n <input type='radio' style='float:right;height:15px;width:20px' value='$rw[codigo]' id='codagenda' name='codagenda'>
                     <input type='hidden' style='float:right;height:15px;width:20px' value='$rw[codigo]' id='codagenda' name='codagenda[]' readonly>
                     </td>                     
                     
                     </tr>
                     
                     <tr>
                     
                     <td>Fecha</td><td>:</td> <td><input type='date' name='txtfecha[]' value='$Fecha'></td>                     
                     </tr>
                     <tr>
                     <td>Hora inicio</td><td>:</td> <td><select name='hora_inicio[]'>";
                     
                     $rs1=$db->query("SELECT * from horas"); 
                     
                     //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
                     
                     
                     while ($row=$db->fetch_assoc($rs1))
                     {
                     
                     
                     
                     if ($row['conversion'] == $inicia) 
                     {
                     echo " <option value='$row[id]' selected='selected'>$row[conversion]</option>";
                     }
                     else
                     {
                     echo " <option value='$row[id]'>$row[conversion]</option>";
                     }
                     
                     } 
                     
                     
                     echo"</select></td>                     
                     </tr>
                     <tr>
                     <td>Hora termina</td><td>:</td> <td><select name='hora_termina[]'>";
                     
                     $rs1=$db->query("SELECT * from horas"); 
                     
                     //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
                     
                     
                     while ($row=$db->fetch_assoc($rs1))
                     {
                     
                     
                     
                     if ($row['conversion'] == $fin) 
                     {
                     echo " <option value='$row[id]' selected='selected'>$row[conversion]</option>";
                     }
                     else
                     {
                     echo " <option value='$row[id]'>$row[conversion]</option>";
                     }
                     
                     } 
                     echo"</select></td>                     
                     </tr>
                     <tr>
                     <td>Exponente</td><td>:</td> <td><input type='text' class='usuarios' name='txtexponente[]' value='$nombre2'></td>                     
                     </tr>
                     <tr>
                     <td>Tema</td><td>:</td> <td><input type='text' name='txttema[]' value='$tema'></td>                     
                     </tr>
                     <tr>
                     <td>Cupos</td><td>:</td> <td><input type='text'  class='numeros' name='txtcupos[]' paceholder='0 es ilimitado' value='$cupos'></td>                     
                     </tr>
                     <tr>
                     <td>Escenario</td><td>:</td> <td><select name='cbmescenario[]'>";
                     
                     $rs1=$db->query("SELECT * from escenario"); 
                     
                     //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
                     
                     
                     while ($row=$db->fetch_assoc($rs1))
                     {
                     
                     
                     
                     if ($row['id'] == $rw['codescenario']) 
                     {
                     echo " <option value='$row[id]' selected='selected'>$row[nombre]</option>";
                     }
                     else
                     {
                     echo " <option value='$row[id]'>$row[nombre]</option>";
                     }
                     
                     } 
                     
                     
                     echo"</select></td>                     
                     </tr>
                     <tr>
                     <td>Ubicacion(direccion)</td><td>:</td> <td><input type='text' name='ubicacion[]' value='$ubicacion' readonly></td>                     
                     </tr>";
                     
                     
                     }
                     ?>
                     
                     
                     
                     
                     
                     
                     
                     </tbody>
                     
                     </table>    
                     
                     
                     <div style="text-align:center; margin-top:10px;padding-top:30px; text-align:right; border-top:1px solid silver">
                     
                     <button  type="button" id="agregar_agenda" onclick="agregar_agenda2()" >Agregar agenda</button>
                 <!--   <button  type="button" onclick="modificar_agenda3()" >Guardar modificacion(es)</button> -->
                     <button  type="button"  onclick="agenda_eliminar()">Eliminar agenda</button>
                     
                     </div>
                     
                     </form>
                     
                     <script type="text/javascript">
                     
                     function agregar_agenda2()
                     {
                     
                     $("#dialogo").show();
                     
                     }

                       function agenda_eliminar()
                    {

                     var age_id=($('input:radio[id=codagenda]:checked').val());
                 
        bootbox.confirm("¿Desea eliminar los datos?", function(result) {

if (result==true) 
{
                   $.post(page_root + "eliminar_agenda","id="+ age_id, function(data) {
               
                 var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                            alert("Eliminado con exito");
                            location.reload();
                        }
                        else
                        {
                    alert(r.msg);
                     $("#error_agenda").html(r.msg);
                     $("#existe_agenda").css({"display":"block","font-size":"200%"});
                        }
                    });

}

});
                    }
                     
                     </script>
                     