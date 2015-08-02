                
                    <div class="ui-state-error ui-corner-all" style="padding: 0.7em;display:none" id="existe_acto" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong>Error:</strong>  <p id="error_acto"> </p>  </p>
                    </div>

                    <form id="frmacto" method="POST" action="descargar_agendas.php" target="_blank" style="border:3px;">
                    
                    <div style="width:75%;border:none;margin:auto">   
                    
                   
                    <input type="hidden" id="txtcodigo" name="txtcodigo" value='<?php echo $acto_numero ?>' style="width:100%" readonly ><br/><br/>
                    
                    Tipo acto:<br/>
                    <select id="cbmtipo_acto" name="cbmtipo_acto">
                    <?php
                    
                    
                    $rs1=$db->query("SELECT * from tipo");
                    
                    //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
                    
                    
                    while ($row=$db->fetch_assoc($rs1))
                    {
                    
                    
                    
                    if ($row['codigo'] == $tipo_acto) 
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
                    
                    <br/><br/>
                    Nombre evento:<br/>
                    <input type="text" id="txtnombreevento" name="txtnombreevento" value='<?php echo $nombre ?>' style="width:100%" ><br/><br/>
                    Descripcion:<br/>
                    <textarea  id="descrip" name="txtdescrip" style="width:50%"   class="jqte-test" > <?php echo $descripcion ?> </textarea><br/><br/>
                    Objetivo:<br/>
                    <textarea id="objetiv" name="txtobjetivo" style="width:60%"   class="jqte-test" ><?php echo $objetivo ?> </textarea>
                    
                    </div>
                    
                    <div style="text-align:center; margin-top:10px;padding-top:20px; text-align:right; border-top:1px solid silver">
                    
                    
                    <button  type="button" id="modificar_acto" onclick="modificar_evento()">Guardar modificacion</button>
                    <button  type="button" id="eliminar_acto" onclick="eliminar_evento()">Eliminar acto</button>
                    
                    
                    </div>
                    </form>
                    
                    <script type="text/javascript">
                    
                    function modificar_evento()
                    {

                         bootbox.confirm("¿Desea modificar los datos?", function(result) {

if (result==true) 
{
                    //alert("hola");
                    $.post(page_root + "modificar_evento", $("#frmacto").values(), function(data) {
                    var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                             bootbox.alert("Actualizado con exito");
                            recargar_pagina(3000);
                        }
                        else
                        {
                     bootbox.alert(r.msg);
                    $("#error_acto").html(r.msg);
                    $("#existe_acto").css({"display":"block","font-size":"200%"});
                       }
                    });
}

});

                    }
                    
                    function eliminar_evento()
                    {

                         bootbox.confirm("¿Desea eliminar los datos?", function(result) {

if (result==true) 
{
                    // alert("hola");
                    $.post(page_root + "eliminar_evento", $("#frmacto").values(), function(data) {
                    var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                             bootbox.alert("Eliminado con exito");
                             recargar_pagina(3000);
                        }
                        else
                        {
                     bootbox.alert(r.msg);
                     $("#error_acto").html(r.msg);
                     $("#existe_acto").css({"display":"block","font-size":"200%"});
                       }
                    });

                    }

});

                    }

                                        
                    
                    </script>
                    
                    
                    
                    
                    
