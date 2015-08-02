
<link rel="stylesheet" href="css/jPages.css">
<script src="js/js.js"></script>
<script src="js/jPages.js"></script>
<script type="text/javascript">
 

                        
    function consultar()
    {
        $.post(page_root + "consultar", $("#formulario").values(), function(data) {
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
$(function(){
    $("div.holder").jPages({
      containerID : "cuerpo-detalles",
      previous : "←",
      next : "→",
      perPage : 5,
      delay : 5
    });
  });


</script>

 <div class="ui-state-error ui-corner-all" style="padding: 0.2em;display:none" id="existe" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right:0.3em;"></span>
                    <strong>Error:</strong>  <p id="error"> </p>  </p>
 </div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" method="POST">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Disponibilidad escenario</th>
            </tr>
 

            <tr> 
                <td class="tdi">Fecha Inicio</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="txtfechainicio" id="txtfechainicio"  value="" title="Fecha Inicio"  maxlength="30"/>
                </td>            
            </tr>

       <!--     <tr> 
                <td class="tdi">Fecha Fin</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="txtfechafin" id="txtfechafin"  value="" title="Fecha Fin"  maxlength="30"/>
                </td>            
            </tr> -->

            <tr> 
                <td class="tdi">Hora inicio</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select name="txtfhorainicio" id="txtfhorainicio"  value="" title="Hora inicio" maxlength="30"/>
                <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?></select>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Hora fin</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select name="txthorafin" id="txthorafin"  value="" title="Hora fin" maxlength="30"/>
                     <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?></select>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Escenario</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmescenario" name="cbmescenario" title="Escenario">
                    <option value="0">Todos</option>
                        <?php
              llenar_combo2("SELECT id as codigo, nombre FROM escenario WHERE estado_id='1'",true);
              ?>
                    </select>
                </td>            
            </tr>                        
                            


        </table>

        <div class="error"></div>
        <div class="acciones">
		<input type="button" name="accion" value="Consultar" onclick="consultar()" />

        </div>

    </form>
</div>
<div class="holder"></div>

<table width="95%" id="reporte" align="center" style="margin-bottom:30px;" class="bordered">
  <thead>
<tr>   
       <th width="30px" >No.</th>
           
        <th  >Nombre Escenario</th>
         <th  >Direccion</th>

         <th  >Horas ocupado</th>
         <th  >Fecha</th>
            
        <th   width="50px">Estado</th>
            
        
            
</tr>
  </thead>

   <tbody id="cuerpo-detalles">


   <?php
if (isset($_POST['txtfhorainicio'])) {

$fecha_inicio=$_POST['txtfechainicio'];
//$fecha_fin=$_POST['txtfechafin'];

if (!empty($fecha_inicio))
{
    $complemento_fecha="AND fecha='$fecha_inicio'";

}/*
elseif ($fecha_fin>$fecha_inicio)
{
    $complemento_fecha="AND fecha='$fecha_inicio' OR fecha='$fecha_fin'";
}else
{
    echo "Fecha inicio mayor a fecha final";
}*/



$hora_inicio=$_POST['txtfhorainicio'];
$hora_fin=$_POST['txthorafin'];

if ($hora_fin==$hora_inicio)
{
   $complemento_hora="AND ('$hora_inicio'>=h_inicia  AND '$hora_inicio'<=h_termina)";
}
elseif
($hora_fin>$hora_inicio)
{
    $complemento_hora="AND (h_inicia>='$hora_inicio' OR '$hora_fin'<=h_termina)";
}else
{
    echo '
    <div class="ui-state-error ui-corner-all" style="padding: 0.2em;display:block" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right:0.3em;"></span>
                    <strong>Error:</strong> Hora inicio mayor a hora final </p>
 </div>';
 exit(0);
  }


$cod_escenario=$_POST['cbmescenario'];

if ($cod_escenario==0) {
    $complemento_escenario="";
}else
{
   $complemento_escenario="AND escenario_id='$cod_escenario'";
}

$sql="SELECT a.*,e.nombre as nombre,e.ubicacion as direccion
FROM agenda a,escenario e
WHERE e.id=a.escenario_id $complemento_hora $complemento_fecha $complemento_escenario
";
$n=0;


//echo "$sql";
$rs=$db->query($sql);

if ($db->num_rows($rs)>0)
        {

while ($row=$db->fetch_assoc($rs))
        {
          $n++;

          $r2=$db->query("SELECT * from horas");
                     
                     while ($rw2=$db->fetch_assoc($r2) /* paso los datos de $r a $rt (rtable) */)
                     {
                     
                     if ($rw2['id']==$row['h_inicia'])
                     {
                     $inicia=$rw2['conversion'];
                     }
                     if ($rw2['id']==$row['h_termina'])
                     {
                     $fin=$rw2['conversion'];
                     }
                     
                     }


            echo " <tr>
                   <td>$n</td>
                   <td>$row[nombre]</td>
                   <td>$row[direccion]</td>
                   <td>De: <b> $inicia </b> a <b> $fin  </b></td>
                    <td><b> $row[fecha] </b></td>
                   <td> <b style=\"color:red\">OCUPADO </b></td>
                   </tr>";
          }
        }
        else
            {
               echo " <tr>
                   <td>1</td>
                   <td>Todos los escenarios</td>
                    <td>Todos los escenarios</td>
                   <td>Disponibles</td>
                      <td>Disponibles</td>
                   <td> <b style=\"color:green\">DISPONIBLES </b></td>
                   </tr>";
            }
        # code...
}
   ?>


   </tbody>

   </table>