<?php


 //###############################################################################

    $s="SELECT a.id as id ,a.nombre,a.descripcion,a.objetivo,t.nombre as tipo,ag.fecha  FROM acto a,tipo t,agenda ag WHERE a.tipo_id=t.codigo and a.id=ag.acto_id ORDER BY  ag.fecha DESC limit 5";
//echo($s);
$num=1;
$c=0;
        $r=$db->query($s); //tomo la informacion de la base de datos
        
       // $municipio = '<option value=""> Seleccione Municipio </option>';

       while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
        {
          $nombre =strtoupper($rw['nombre']);
          $n=strtolower($rw['nombre']);
          //$n="fabio garcia alvarez renteria gomez gonzales";
          $nombre2 = substr ($n,0,20);
          $nombre2 = ucwords($nombre2);

          $descripcion =strtoupper($rw['descripcion']);
          $d=strtolower($rw['descripcion']);
          $descripcion2 = substr($d,0,70);
          $descripcion2= ucwords($descripcion2)."..";

          $objetivo =strtoupper($rw['objetivo']);



          $fecha = explode("-",$rw['fecha']);

          $fecha_mes="";
          switch ($fecha[1]) {
            case 01:
              $fecha_mes='Enero';
              break;
              case 02:
              $fecha_mes='Febrero';
              break;
              case 03:
              $fecha_mes='Marzo';
              break;
              case 04:
              $fecha_mes='Abril';
              break;
               case 05:
              $fecha_mes='Mayo';
              break;
              case 06:
              $fecha_mes='Junio';
              break;
              case 07:
              $fecha_mes='Julio';
              break;
              case 08:
              $fecha_mes='Agosto';
              break;
               case 09:
              $fecha_mes='Septiembre';
              break;
              case 10:
              $fecha_mes='Octubre';
              break;
              case 11:
              $fecha_mes='Noviembre';
              break;
              case 12:
              $fecha_mes='Diciembre';
              break;
                    
            default:
              $fecha_mes="";
              break;
          }
          //echo $num;
          
              if ($c!=$rw['id'])
               {
            
             @$menu2.="

              <li>
                <figure><strong>$fecha[2]</strong>$fecha_mes</figure>
                <h3><a href='#' id='$rw[id]' class='enviar'>$nombre2</a></h3>
               $descripcion2.
               <a href='#' id='$rw[id]' class='enviar'>Ver mas...</a>
              </li>";
              $c=$rw['id'];

            //  echo $menu2;

            }

            }
            
            
            $num+=1;

?>
<script type="text/javascript">

$(document).ready(function()  {
        
        $("#frminformacion").submit(function() {
            $.ajaxSetup({async: false});
            $.post(page_root + "validar", $("#frminformacion").values(), function(data) {
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
 
 $(document).ready(function(e) {
               
        $("#txtbuscar").autocompletar2(page_root + "listarEventos", {
            form: "formulario",
            inputId: "eventoId",
            minLength: 3});        
    });
                       
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
                alert(r.msg);
            } else
            {
            
            var r = jQuery.parseJSON(data);
            $("#cuerpo-detalles").html(r.tabla);
           
            }
        });
    }


</script>

<div style="width:900px;height:150px; margin:auto;">

<div style="width:140px;float:left">
   <img src="img/iconos/eventos.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; padding-top:40px;">

    <form id="formulario" method="POST" accion="">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Eventos</th>
            </tr>
 

            <tr> 
                <td class="tdi">Buscar Evento</td>
                <td class="tdc">:</td>
                <td class="tdd">

    <input type="hidden" name="eventoId" id="eventoId" 
                           class="no-modificable" title="Buscar">
                   
                    <input type"text" id="txtbuscar" name="txtbuscar" title="Buscar Evento" required >
                        
                </td>            
            </tr>


        </table>

        <div class="error"></div>
        <div class="acciones">
		<input type="submit" name="accion" value="Buscar"  class="accion-buscar" />

        </div>

    </form>


</div>
</div>

<link rel="stylesheet" href="css/jPages.css">
<script src="js/js.js"></script>
<script src="js/jPages.js"></script>
<script src="js/eventos.js"></script>
<link type="text/css" href="css/eventos.css" rel="stylesheet" />
   

 <style type="text/css">  
        
        #reporte { border-collapse:collapse;}
        #reporte img { float:right;}
        #reporte div.arrow { background:transparent url(img/agenda.png) no-repeat scroll ;
         width:16px; height:16px; display:block; cursor: pointer;}
         input 
         {
           height: 26px;
            border-radius: 4px;
         }


    </style>


<div id="detalles-todo"style="width:100%;height:500px;">

           <div id="izquierda" style="float:left;margin-left:20px;width:302px;">
    <div class="holder"></div>        
          <h2 class="ui-state-active" style="height:20px; text-align:center;padding-top:4px" >Eventos Recientes </h2>
            
            <!-- .news -->
            <ul class="news" style="border-right:2px solid #eee;">
<?php

  echo(@$menu2);
?>

            </ul>
            <!-- /.Nuevos -->
       </div>

<div id="derecha" style="float:right;  width:600px; margin-right:20px;">
          <!-- contenido-centro -->

</form>
  <div class="holder"></div>

    <h2  class="ui-state-active" style="height:20px; text-align:center;padding-top:4px" >Resultado Búsqueda </h2>
            
 <table width="100%" id="reporte" align="center" style="margin-bottom:30px;" class="bordered">
  <thead>
<tr>   
       <th width="30px" >No.</th>
           
        <th  >Nombre</th>
            
        <th   width="50px">Tipo</th>
            
        <th width="30px">Ver</th>
            
</tr>
  </thead>


        <tbody id="cuerpo-detalles">

<?php

if (isset($_POST['txtbuscar']) and isset($_POST['eventoId']) ) {
  

@$id =$_POST['eventoId'];

$sc="SELECT contenido as conclusion from conclusion WHERE acto_id='$id'";
//echo "$sc";
$rc=$db->query($sc);

if ($db->num_rows($rc)>0)
{
  $rc2=$db->fetch_assoc($rc);
  $conclusion_EVENTO=$rc2['conclusion'];
//echo($conclusion_EVENTO);
//exit();
}


$s="SELECT a.id,a.nombre,a.descripcion,a.objetivo,t.nombre as tipo FROM acto a,tipo t WHERE a.id='$id' and t.codigo =a.tipo_id";
//echo($s);
        $r=$db->query($s); //tomo la informacion de la base de datos

        
if ($db->num_rows($r)==0) {

echo"<div class='ui-widget'>
  <div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>
    <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>
    <strong>Alerta:</strong> No hay registro con el evento solicitado : $_POST[txtbuscar].</p>
  </div>
</div>";
 

}
else
{
  echo" <div class='ui-widget'>
  <div class='ui-state-highlight ui-corner-all' style='margin-top:0px; padding: 1 .7em;'>
    <p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
    <strong>Informacion</strong> Dar clic al icono ver, para mas detalles</p>
  </div>
</div>";
       while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
        {
          $descripcion =strtoupper($rw['descripcion']);
          $objetivo =strtoupper($rw['objetivo']);
          $nombre =strtoupper($rw['nombre']);
          $id =$rw['id'];
          $tipo=$rw['tipo'];
            
@$opciones.="<tr onclick='myFunction(this)'>
            <td>$rw[id]</td>
            <td>$nombre</td>
            <td>$tipo</td>
            <td class='ocultar'>$descripcion</td>
            <td class='ocultar'>$objetivo</td>
           <td><div class='arrow'></div></td>
        </tr>";

        } 
  echo @$opciones;
        
}
 }      
                  
?>



        </tbody>        
  </table>
            
                    <div>
<?php 

if (isset($_POST['txtbuscar']) and isset($_POST['eventoId']) )
 {
  
  $sql="SELECT * from galeria WHERE cod_evento='$_POST[eventoId]' LIMIT 5";
  $r=$db->query($sql);

  $url[4];
  $descripcion[4];


if ($db->num_rows($r)>0)
{
  
  $i=0;
while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)
        {
          $url[$i]=$rw['imagen_grande'];
          $des[$i]=$rw['descripcion'];
          $i++;
        }

    require_once("modulos/Servicios/eventos/galeria.php") ;
}


}
?>
     
                </div>            

</div>

</div>
</div>


<div id="dialogo" title="Agenda" style="margin:auto;color:#000;line-height:28px;font-size:15px;text-align:justify;">
       
<link type="text/css" rel="stylesheet" href="css/easy-responsive-tabs.css" />
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>

<style type="text/css">
button 
{
   text-align: left;
}
 </style>   

 <form id="frminformacion" method="post"  target="_blank" 
        action="<?php echo PAGE_ROOT . "mostrar" ?>" style="border-top:3px;">
   
<div style="height:80%;width:90%;padding:6px;border-radius:8px;margin:auto;margin-top:20px;margin-bottom:10px">

 <div id="verticalTab">

            <ul class="resp-tabs-list">
                <li>Informacion del acto</li>
                <li>Conclusiones</li>
                <li>Agenda</li>
                <li>Imprimir agenda</li>
                 
            </ul>

  <div class="resp-tabs-container">
                


                <div>

<input type="hidden" id="txtcodigo" name="txtcodigo" value="<?php echo $id ?>" style="width:100%" readonly>

Nombre evento:<br/>
<input type="text" id="txtnombreevento2" name="txtnombreevento2" value="<?php echo $nombre ?>" style="width:100%" readonly><br/>
Descripcion:<br/>
<textarea id="descrip" name="txtdescrip" style="width:100%;height:100px" readonly><?php echo $descripcion ?></textarea><br/>
Objetivo:<br/>
<textarea id="objetiv" name="txtobjetiv" style="width:100%;height:100px" readonly><?php echo $objetivo ?></textarea>

                </div>

<div>

<textarea name='txt' id='txt' style="height:250px;width:90%;" readonly>
<?php echo $conclusion_EVENTO; ?>
</textarea>


</div>
            
                <div>
<?php require_once("modulos/Servicios/eventos/agenda.php") ?>
                </div>
                
                <div>

                <a class="items">
    <div class="icono">
        <img src="img/iconos/detalles.png" alt="" style="width:60px" />
    </div>
    <div class="texto">
        <span>Imprimir agenda</span>
        <div>Desde esta opci&oacuten podrá imprimir la agenda completa de este evento  en varios formatos.</div>
    </div>
</a>
                <center>
                    <table align="center" cellpadding="1" style="width:90%;"><!--491 -->
      <tbody>
              
              <tr>
                <td style="width:100px;">Tipo reporte</td>
                <td style="width:10px;"></td>
                <td >
                <select title="Tipo reporte" name="tipo" id="tipo" style="width:100%;">
                    <option value="1">Relación general: agenda completa</option>
                </select>
                </td>
              </tr>
           
              <tr>
                <td>Formato</td>
                <td></td>
                <td>
                    <select name="formato" style="width:100%;">
                        <option value="pdf">Archivo PDF</option>
                        <option value="excel">Hoja de calculo de Excel</option>
                        <option value="word">Archivo de Word</option>
                   </select>
                </td>
              </tr>     
         
              <tr>
                    <td colspan="3" align="right" style="paddingx-top:10px;" >
                        <input  type="submit"  value="Aceptar" style="width:120px" />
                    </td>       
              </tr>
                
      </tbody>
    </table>
        </center>
                </div>

                 

            </div>
        </div>



</div>
</form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });
    });
</script>
 <script>
    $(function() {
         
  $(".enviar").click(function(){

            var id = $(this).attr('id');

         //alert(id);
          $("#eventoId").val(id);
            // alertify.alert("Dar click en ver para mas detalles");
          $("#formulario").submit();


            });
        
      

    
    });
    </script>
