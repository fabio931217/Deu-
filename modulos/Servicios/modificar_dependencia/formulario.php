<script type="text/javascript">

 function cargarEventos()
 {
        
        cargarCombo(page_root + "cargarEventos", "formulario", "cbmevento", true);
       
 }

  function cargarAgendas()
 {
   //alert("hola");
    $.post(page_root + "cargarAgendas", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
           //alert(r);
            $("#cbmagenda").html(r);
         });
       
 }

$(document).ready(function(e) {
         $(".ocultar,#ocultar").hide();
        $('#txtdocumento').autocomplete({
            source: function(request, response) {
            $.ajax({
            url: "auto_usuarios2.php",
            dataType: "json",
            data: {
              term : request.term,
              evento : $("#cbmevento").val()
             },
            success: function(data) {
                 response(data);
                  }
                  });
                  },
                  form: "formulario",
            inputId: "persona_id",
            minLength: 2});   
          
    });                

function guardar_modificacion()
    {
                bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
        $.post(page_root + "guardar_modificacion", $("#dependencia").values(), function(data) {
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
            }
             else
            {              

             bootbox.alert(r.msg)
             recargar_pagina(3000);
            }

            
        });
    }

});
    }
                        
    function aceptar()
    {
        $.post(page_root + "aceptar", $("#formulario").values(), function(data) {
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
            } else
            {
                $("#formulario").submit();
            }
        });
    }


</script>
<link rel="stylesheet" href="css/jPages.css">
<script src="js/js.js"></script>
<script src="js/certificados.js"></script>
<script src="js/jPages.js"></script>


<div class="ui-widget">
 <div class="ui-state-error ui-corner-all" style="padding: 0.2em;display:none" id="existe" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right:0.3em;"></span>
                    <strong>Error:</strong>  <p id="error"> </p>  </p>
 </div>
 </div>
<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" method="POST">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Modificar Dependencia</th>
            </tr>
 

            <tr> 
                <td class="tdi">Tipo evento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmtipo" name="cbmtipo" title="Tipo evento" onChange="cargarEventos()">
                         <?php
                        llenar_combo("SELECT * FROM tipo", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Evento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmevento" name="cbmevento" title="Evento" onChange="cargarAgendas()">
                        <?php
                        llenar_combo("PONER_SQL_AQUI", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Agenda</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmagenda" name="cbmagenda" title="Agenda">
                        <?php
                        llenar_combo("PONER_SQL_AQUI", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Documento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtdocumento" id="txtdocumento"  value="" title="Documento" maxlength="30"/>
                </td>            
            </tr>


        </table>

        <div class="error"></div>
        <div class="acciones">
		<input type="button" name="accion" value="Consultar" onclick="aceptar()" class="accion-aceptar" />

        </div>

    </form>
</div>


<div class="holder"></div>
<?php 


if (isset($_POST['cbmagenda'])) {

$persona=$_POST['txtdocumento'];

$id_persona=explode("-", $persona);
echo "
<div class='ui-state-highlight ui-corner-all' style='padding: 0.2em;display:block' id='existe'>
            <p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
                <strong>Informacion usuario:</strong> <b> $id_persona[1]  </p>
</div>";

echo '
<form  id="dependencia" >

 <table width="80%"  id="reporte" name="reporte" align="center" style="margin-top:20px;border-radius:12px " class="bordered">
  <thead>
        <thead>
        <tr>
            <th width="15%" style="border-radius:8px 0px 0px 8px"> <input type="checkbox" name="todo[]" id="check_todo" onChange="checkbox()"> Seleccione</th>
            <th width="30%" >Fecha/Hora asistencia</th>
            <th width="40%" style="border-radius: 0px 8px 8px 0px;width:5px">Dependencia <select id="combo_todo" onChange="combos()" style="width:70%">';

            llenar_combo("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre", true);

   echo '</select></th>
        </tr>
  </thead>
        <tbody id="cuerpo-detalles">';


$id_agenda=$_POST['cbmagenda'];
//echo $id_agenda;


if ($id_agenda==0)
{
   $codicion="";
    
}else
{
    $codicion= "r.agenda_id='$id_agenda' and";
}


$s="SELECT * FROM asistencia r
WHERE ".$codicion." r.persona_id='$id_persona[0]'";

//echo $s;
$r=$db->query($s);
$n=0;
while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
        {
                   
echo "<tr>
            
             <td> <input type='checkbox' name='cod_agenda[]' id='asistencia_id'  class='check' value='$n-$rw[id]' style='margin-left:20px'> </td>
            <td>$rw[fecha_hora]</td>
            <td> <select name='cbmfuncion[]' class='combo' id='combo' style='width:90%';padding:20px;>";

$rs=$db->query("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre"); 

        //echo"<div style='border:1px red solid; text-align:center;width:70%;box-shadow:0px 0px 8px;margin:auto'> El numero: $rw[sexo], fue eliminado exitosamente </div>";
 

       while ($row=$db->fetch_assoc($rs))
        {
          

          
          if ($row['codigo'] == $rw['dependencia_id']) 
          {
             echo " <option value='$row[codigo]' selected='selected'>$row[nombre]</option>";
          }
          else
          {
            echo " <option value='$row[codigo]'>$row[nombre]</option>";
          }
           
        } 





        echo "</select></td>
                
        </tr> ";
$n++;
        } 

   echo '      
        
        </tbody>     
  </table>

<div class="acciones">
        <input type="button" name="accion" value="Guardar Modificacion(es)" onclick="guardar_modificacion()" class="accion-aceptar" />

        </div>
  </form>';
}

?>
