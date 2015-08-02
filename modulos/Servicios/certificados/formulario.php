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
               
            }
        });
    }


</script>

<link rel="stylesheet" href="css/jPages.css">
<script src="js/js.js"></script>
<script src="js/funciones.js"></script>
<script src="js/jPages.js"></script>
<script src="js/certificados.js"></script>
   

 <style type="text/css">  
        
        #reporte { border-collapse:collapse;}
        #reporte img { float:right;}
        
        #reporte div.arrow { 
            background:transparent url(img/pdf.png) no-repeat scroll ;
            cursor: pointer;
           width:16px; height:16px; display:block;}


</style>

<div style="width:900px;height:150px; margin:auto;">

<div style="width:140px;float:left">
   <img src="img/iconos/certificados.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; padding-top:40px;">

    <form id="formulario" method="POST">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Certificados</th>
            </tr>
 

            <tr> 
                <td class="tdi">Buscar certificado</td>
                <td class="tdc">:</td>
                <td class="tdd">

                       <select id="cbmcertificado" name="cbmcertificado" title="Buscar certificado" class="chosen-select" >
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
<form  id="certificar"  method="POST" method="post"  target="_blank" 
        action="<?php echo PAGE_ROOT . "mostrar" ?>">

<input type="hidden" class="ocultar" name="idacto" id="idacto" value='<?php echo @$_POST[cbmcertificado];  ?>'>
<input type='hidden' class="ocultar" name='idagenda' id='idagenda' value=''>

 <table width="98%"  id="reporte" name="reporte" align="center" style="margin-bottom:30px;border-radius:12px " class="bordered">
  <thead>
        <thead>
        <tr>
            <th style="border-radius:8px 0px 0px 8px">No.</th>
            <th>Fecha/Hora asistencia</th>
            <th>Funcion</th>
            <th>Dependencia</th>
            <th style="border-radius: 0px 8px 8px 0px;width:5px">Certificar</th>
        </tr>
  </thead>
        <tbody id="cuerpo-detalles">
       
 <?php

if (isset($_POST['cbmcertificado']) and !empty($_POST['cbmcertificado'])) {

$id_acto=$_POST['cbmcertificado'];



$s="SELECT r.id,ag.acto_id,r.fecha_hora,f.nombre as funcion, CONCAT_WS(' : ',i.nombre,d.nombre) as dependencia 
FROM asistencia r,funcion f,dependencia d,institucion i,agenda ag 
WHERE f.codigo=r.funcion_id and ag.id=r.agenda_id and d.id=r.dependencia_id and d.institucion_id=i.codigo and ag.acto_id='$id_acto' and r.persona_id='$_SESSION[persona_id]'
";

//echo $s;
$r=$db->query($s);

while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
        {
       $no++;              
echo "<tr onclick='prueba(this)' style='cursor:pointer;'>
            <td>$no</td>
            <td class='ocultar'>$rw[id]</td>
            <td>$rw[fecha_hora]</td>
            <td>$rw[funcion]</td>
            <td>$rw[dependencia]</td>
            <td width='20px'> <button type='submit' class='accion-mostrar-reporte'> <div></div> Certificar <button> </td>
          
        </tr> ";

        } 
}
   ?>
   
        
        
        </tbody>     
  </table>
  

</form>

<script type="text/javascript">
    
  $(document).ready(function()  {
        
        $(".ocultar").hide();

        $("#certificar").submit(function() {
            //alert("hola");
            $.ajaxSetup({async: false});
            $.post(page_root + "validar", $("#certificar").values(), function(data) {
                var r = jQuery.parseJSON(data);
                if (r.error == true)
                {
                    for (ind in r.bad_fields)
                    {
                        $("#" + r.bad_fields[ind]).addClass("error");
                    }
                    alert(r.msg);
                } else {
                    return true;
                }
            });

            return false;
        });

            });



</script>


