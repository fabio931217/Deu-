<style type="text/css">
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 12px;
        text-align: center;
    }

</style>
<script type="text/javascript" src="js/diseno_certificado.js"></script>

 <center><div class="messages" style="padding: 0 .7em;display:none" id="existe2"> <img src="img/pb.gif"> Subiendo datos...</div></center>
<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;display:none" id="existe" >
            <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Advertencia:</strong>  <p id="error"> </p>  </p>

                <input type="button" id="actualizar" name="actualizar" value="Actualiar" onclick="actualizar()" class="accion-aceptar" style="margin-left:760px;display:none" />

</div>

<div style="width:900px;min-height:150px; margin:auto;">



<div style="width:140px;float:left">
   <img src="img/iconos/asistencia3.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" enctype="multipart/form-data" class="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Diseño Certificado y Escarapela</th>
            </tr>

             <tr> 
                <td class="tdi">Tipo Evento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmtipo" name="cbmtipo" title="Tipo Evento" onChange="cargarEventos()">
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
                    <select id="cbmevento" name="cbmevento" title="Evento" >
                        <?php
                       // llenar_combo("SELECT id,nombre FROM acto", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Tipo Diseño</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmtipodiseno" name="cbmtipodiseno" title="Tipo Diseño" onchange="cambiar_diseño()">
                        <?php
                       llenar_combo("SELECT * FROM tipo_diseno", true);
                        ?>
                    </select>
                </td>            
            </tr>   

          <tr> 
                <td class="tdi">Tipo Objeto</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmobjeto" name="cbmobjeto" title="Tipo Diseño" onchange="cambiar_diseño()">
                        <?php
                       llenar_combo("SELECT * FROM tipo_objeto", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
            
            <tr> 
                <td class="tdi">Funcion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                   
                    <select id="cbmfuncion" name="cbmfuncion" title="Tipo Diseño" onchange="cambiar_diseño()">
                        
                        <?php
                       llenar_combo2("SELECT * FROM funcion", true);
                        ?>
                         
                    </select>
                </td>            
            </tr>                

            <tr class="ocultar"> 
                <td class="tdi">Archivo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                   <input   type="file" name="archivo" id="imagen" />
                 <!--  <input  type ="text" name="prueba" id="prueba2" /> -->
                </td>            
            </tr>


        </table>

        
        <div class="acciones">
		<input type="button" name="accion" value="Aceptar" onclick="aceptar()" class="accion-aceptar" />

        </div>

    </form>
</div>
</div>
<br/>
<center>
<img id="imgSalida" width="80%" height="60%" src="" />
</center>



