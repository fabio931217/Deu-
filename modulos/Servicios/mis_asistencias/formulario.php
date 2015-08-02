<script type="text/javascript">
                        
    function buscar()
    {
        $.post(page_root + "buscar", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                 bootbox.alert(r.msg);
            } else
            {
                $("#formulario").submit();
           /*var r = jQuery.parseJSON(data);
            $("#cuerpo-detalles").html(r.tabla);*/
            }
        });
    }


</script>

<link rel="stylesheet" href="css/jPages.css">
<script src="js/js.js"></script>
<script src="js/jPages.js"></script>
<script src="js/asistencias.js"></script>

   

 <style type="text/css">  
        
        #reporte { border-collapse:collapse;}
        #reporte img { float:right;}
        
        #reporte div.arrow { background:transparent url(img/agenda.png) no-repeat scroll ;
         width:36px; height:34px; display:block;}


    </style>

<div style="width:900px;height:150px; margin:auto;">

<div style="width:140px;float:left">
   <img src="img/iconos/asistencia.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; padding-top:40px">
    <form id="formulario" method="POST">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Asistencias</th>
            </tr>
 

            <tr> 
                <td class="tdi">Buscar Asistencia</td>
                <td class="tdc">:</td>
                <td class="tdd">

                    <select  id="cbmasistencia" name="cbmasistencia" title="Buscar Asistencia" class="chosen-select" >
                   
                   <?php

                    llenar_combo("SELECT a.id as codigo,CONCAT_WS(' ',t.nombre,' : ',a.nombre,' ( ',ag.fecha, ')') AS nombre FROM acto a,tipo t,agenda ag,asistencia asis WHERE a.tipo_id=t.codigo and a.id=ag.acto_id and ag.id=asis.agenda_id and asis.persona_id='$_SESSION[persona_id]' group by codigo",TRUE);  ?>
                 
                    </select>
                </td>            
            </tr>                        
                            


        </table>

        <div class="error"></div>
        <div class="acciones">
		<input type="button" name="accion" value="Buscar" onclick="buscar()" />

        </div>

    </form>
</div>
</div>

 <div class="holder"></div>
<form name="certificar" id="certificar"  method="POST" action="reportes/descargar_certificados.php" target="_blank">

 <table width="98%"id="reporte" name="reporte" align="center" style="margin-bottom:30px;border-radius:12px " class="bordered">
  <thead>
        <thead>
        <tr>
            <th style="border-radius:8px 0px 0px 8px">No.</th>
            <th>Fecha/Hora asistencia</th>
            <th>Funcion</th>
            <th  style="border-radius: 0px 8px 8px 0px">Dependencia</th>
            
        </tr>
  </thead>
        <tbody id="cuerpo-detalles">
   
   <?php

if (isset($_POST['cbmasistencia']) and !empty($_POST['cbmasistencia'])) {

$id_acto=$_POST['cbmasistencia'];



$s="SELECT ag.acto_id,r.fecha_hora,f.nombre as funcion,i.nombre as institucion,d.nombre as dependencia 
FROM asistencia r,funcion f,dependencia d,institucion i,agenda ag 
WHERE f.codigo=r.funcion_id and ag.id=r.agenda_id and d.id=r.dependencia_id and d.institucion_id=i.codigo and ag.id='1' and r.persona_id='$_SESSION[persona_id]'";

//echo $s;
$r=$db->query($s);
$no;
while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
        {
       $no++;              
echo "<tr onclick='myFunction(this)'>
            <td>$no</td>
            <td>$rw[fecha_hora]</td>
            <td>$rw[funcion]</td>
            <td>$rw[institucion] - $rw[dependencia]</td>
            
          
        </tr> ";

        } 
}
   ?>
   
         

        
        </tbody>     
  </table>
 </form>
