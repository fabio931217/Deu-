
<script type="text/javascript">

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
                alert("No hay errores de validación");
            }
        });
    }


</script>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" method="POST">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Editar Eventos</th>
            </tr>
 

            <tr> 
                <td class="tdi">Busca Evento</td>
                <td class="tdc">:</td>
                <td class="tdd">

                 <input type="hidden" name="eventoId" id="eventoId" 
                           class="no-modificable" title="Buscar">

                    <input type="text" id="txtbuscar" name="txtbuscar" title="Busca Evento" >
                       
                </td>            
            </tr>                        
                            


        </table>

        <div class="error"></div>
        <div class="acciones">
		<input type="submit" name="accion" value="Buscar"  />

        </div>

    </form>
</div>


<!--- TinyMCE --> 

<script type="text/javascript" src="js/editor/tiny_mce/tiny_mce.js"></script> 
<link rel="stylesheet" href="css/jPages.css">
<script src="js/js.js"></script>
<script src="js/jPages.js"></script>
<script src="js/editar_eventos.js"></script>
<link type="text/css" href="css/registros.css" rel="stylesheet" />


  <style type="text/css">  
        
        #reporte { border-collapse:collapse;}
        #reporte img { float:right;}
            #reporte th { 
          background-color:#004000;
          color:#fff; padding:7px 15px;
          text-align:left;
          height: 20px;
          box-shadow: 0px 0px 8px;


        }
        #reporte td { background:#fff none repeat-x scroll center left; color:#000; padding:7px 15px; }
        #reporte tr {cursor:pointer; border-top: 1px solid #ddd;}
        #reporte div.arrow { background:transparent url(img/agenda.png) no-repeat scroll ;
         width:36px; height:34px; display:block;}
h1
{
  text-align:center; 
    
  margin-bottom:10px;
  padding:7px 15px;
  background-color:#004000; 
  /*color:#067338;*/
  border-radius: 8px;
  color:#fff;
}

    </style>



            


<?php
if (isset($_POST['eventoId']) and !empty($_POST['eventoId']))

{
          $acto_numero= $_POST['eventoId'];
          $_SESSION['acto_numero'] = $_POST['eventoId'];

          

          $s2="SELECT a.id as id ,a.tipo_id,a.nombre,a.descripcion,a.objetivo,t.nombre as tipo,ag.fecha
          FROM acto a,tipo t,agenda ag 
          WHERE a.tipo_id=t.codigo and a.id=ag.acto_id and a.id='$acto_numero' ";
          //echo($s);
          
          $r=$db->query($s2); //tomo la informacion de la base de datos
          $rw=$db->fetch_assoc($r);
          // $municipio = '<option value=""> Seleccione Municipio </option>';
          $s="SELECT * from acto WHERE id='$acto_numero'";
          $r2=$db->query($s);

          while ($rw2=$db->fetch_assoc($r2) /* paso los datos de $r a $rt (rtable) */)
          {
          
          $tipo_acto = $rw2['tipo_id'];
          $nombre =strtoupper($rw2['nombre']);
          
          $descripcion =strtoupper($rw2['descripcion']);
          
          $objetivo =strtoupper($rw2['objetivo']);

      

         
        }

require_once("modulos/Servicios/editar_eventos/inicio.php");


}
else
{
 
echo"<div class='ui-state-error ui-corner-all' style='margin-top:10px;padding: 0.2em;display:block' id='existe'>
            <p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>
              <strong>Advertencia:</strong>  Ingrese evento  </p>
</div>";
}
?>