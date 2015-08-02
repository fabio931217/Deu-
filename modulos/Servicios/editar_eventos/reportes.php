
<link type="text/css" rel="stylesheet" href="css/easy-responsive-tabs.css" />
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>

    <style type="text/css">
button 
{
   text-align: left;
}
 </style>   



<div style="height:200px;width:80%;padding:6px;border-radius:8px;margin:auto;margin-top:60px;margin-bottom:100px">

        <div id="verticalTab">
            <ul class="resp-tabs-list">
                <li>Reporte delegados</li>
                <li>Reporte organizadores</li>
                <li>Imprimir agenda</li>
              <!--  <li>Conclusiones</li> -->
            </ul>
            <div class="resp-tabs-container">
                <div>
                    
<form name="reporteagendas" method="POST" action="reportes/descargar_delegados.php" target="_blank">
                    <input type="hidden" id="txtcodigo" name="txtcodigo" value='<?php echo $id[0] ?>' style="width:100%" readonly >
                    <input type="hidden" id="txtnombreevento2" name="txtnombreevento2" value='<?php echo $nombre ?>' style="width:100%" >
                    <input type="hidden" class="textarea" id="descrip" name="txtdescrip" style="width:100%" value='<?php echo $descripcion ?>'>
                    <input type="hidden" class="textarea" id="objetiv" name="txtobjetiv" style="width:100%" value='<?php echo $objetivo ?>'>
                    
<a class="items">
    <div class="icono">
        <img src="img/iconos/delegados.png" alt="" style="width:90px" />
    </div>
    <div class="texto">
        <span style="text-align:left">Reporte delegados</span>
        <div>Desde esta opci&oacuten podrá imprimir todos los delegados de este evento  en varios formatos, con su nombre y documento.</div>
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
                    <?php echo $sexo ?>
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
                        <option value="html">Ver en el navegador</option>
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
	




                    </form>
                   
                </div>


                <div>

     <form name="reporteagendas" method="POST" action="reportes/descargar_organizadores.php" target="_blank">
                    <input type="hidden" id="txtcodigo" name="txtcodigo" value='<?php echo $id[0] ?>' style="width:100%" readonly >
                    <input type="hidden" id="txtnombreevento2" name="txtnombreevento2" value='<?php echo $nombre ?>' style="width:100%" >
                    <input type="hidden" class="textarea" id="descrip" name="txtdescrip" style="width:100%" value='<?php echo $descripcion ?>'>
                    <input type="hidden" class="textarea" id="objetiv" name="txtobjetiv" style="width:100%" value='<?php echo $objetivo ?>'>
                    
<a class="items">
    <div class="icono">
        <img src="img/iconos/organizador.png" alt="" style="width:90px" />
    </div>
    <div class="texto">
        <span style="text-align:left">Reporte organizadores</span>
        <div>Desde esta opci&oacuten podrá imprimir todos los organizadores de este evento  en varios formatos.</div>
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
                  <?php echo $sexo ?>
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
                        <option value="html">Ver en el navegador</option>
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
	




                    </form>


</div>


                <div>
<form name="reporteagendas" method="POST" action="reportes/descargar_agendas.php" target="_blank">
                    <input type="hidden" id="txtcodigo" name="txtcodigo" value='<?php echo $id[0] ?>' style="width:100%" readonly >
                    <input type="hidden" id="txtnombreevento2" name="txtnombreevento2" value='<?php echo $nombre ?>' style="width:100%" >
                    <input type="hidden" class="textarea" id="descrip" name="txtdescrip" style="width:100%" value='<?php echo $descripcion ?>'>
                    <input type="hidden" class="textarea" id="objetiv" name="txtobjetiv" style="width:100%" value='<?php echo $objetivo ?>'>
                    
                    
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
                        <option value="html">Ver en el navegador</option>
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

                    </form>
                </div>
          <!--      <div>
                    <p>d ut ornare non, volutpat vel tortor. Integer laoreet placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. Proin nunc erat, gravida a facilisis quis, ornare id lectus. Proin consectetur nibh quis urna gravida mollis.Suspendisse blandit velit eget erat suscipit in malesuada odio venenatis.</p>
                </div> -->

            </div>
        </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });
    });

    function enviar_reporte() {

alert("Hola");
        $(this).submit();
        // body...
    }
</script>