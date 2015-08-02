<script type="text/javascript" src="js/imprimir_certificados_escarapelas.js"></script>

<div class='ui-state-highlight ui-corner-all' style="padding: 0.7em;display:block" id="existe">
            <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                <strong>Informacion:</strong>  <ol>
                    
                    <li>LLenar los campos en orden</li>
                    <li>Si desea imprimir todos los usuarios, ingrese un dato de cualquiere usuario o dejarlo vacio</li>
                </ol>  </p>
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" method="post"  target="_blank" 
        action="<?php echo PAGE_ROOT . "mostrar" ?>">
        <table style="width:100%">
            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Imprimir Certificados Escarapelas</th>
            </tr>


     

            <tr> 
                <td class="tdi">Tipo Evento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmtipoevento" name="cbmtipoevento" title="Tipo Evento" onChange="cargarEventos()">
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
                    <select id="cbmevento" name="cbmevento" title="Evento" onblur="evento()">
                        <?php
                       // llenar_combo("PONER_SQL_AQUI", true);
                        ?>
                    </select>
                </td>            
            </tr>          
 <tr> 
 <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">DATOS</th>

                 <tr> 
                <td class="tdi">Imprimir</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmimprimir" name="cbmimprimir" title="imprimir" onChange="cargarDependencia()">
                        <option value="0">SOLO UN USARIO</option>
                        <option value="1">TODOS LOS USUARIOS DEL EVENTO</option>
                    </select>
                </td>            
            </tr>    
            </tr>
                <td class="tdi">Documento</td>
                <td class="tdc">:</td>
                <td class="tdd">

               
                  <input type="hidden" name="persona_id" id="persona_id" 
                           class="no-modificable" title="Persona">

                    <input type="text" name="txtdocumento" id="txtdocumento" 
                           class="no-modificable" title="Persona" onblur="separar()">

       <!--        <input type="hidden" id="id" name="id" title="Documento" class="no_modificable" disabled="disable" readonly />
                <input type="text" class="search" id="searchid" name="txtdocumento" title="Documento" placeholder="Buscar usuario" style='text-transform:uppercase;' />
<div id="result"> -->


               </td>            
            </tr>    
                          
               <tr> 
                <td class="tdi">Objeto</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmobjeto" name="cbmobjeto" title="Objeto" onChange="cargarDependencia()">
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
                    <select id="cbmfuncion" name="cbmfuncion" title="Objeto">
                         <?php
                       llenar_combo("SELECT * FROM funcion ORDER BY nombre", false);
                        ?>
                    </select>
                </td>            
            </tr> 
                                        
              

             <tr  class="ui-state-active" style="height:24px" id="ocultar">
                <th colspan="3">Dependencia(s) con las que asistio</th>
            </tr>
          <tr class="ocultar" class="ocultar"> 
                <td class="tdi">Dependencia</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmdependencia" name="cbmdependencia" title="Funcion">
                         
                        <?php
                      // llenar_combo2("SELECT * FROM funcion", true);
                        ?>
                    </select>
                </td>            
            </tr>        

                                 
                            

                             
             <tr> 
                <td class="tdi">Fondo imagen</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="fondo_imagen" name="fondo_imagen">
                        <option value="0">CON FONDO</option>
                         <option value="1">SIN FONDO</option>
                    </select>
                </td>            
            </tr>    

            <tr> 
                <td class="tdi">Formato</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="formato" name="formato">
                        <option value="PDF">Documento PDF</option>
                    </select>
                </td>            
            </tr>
        </table>

        <div class="acciones">
            <input type="submit" value="Mostrar" class="accion-mostrar-reporte"/>
        </div>
    </form>
</div>
<script type="text/javascript">



    function separar() {

        
        var str =$("#txtdocumento").val();
        var res = str.split("-");
        
        document.getElementById("persona_id").value=res[0];
        document.getElementById("txtdocumento").value=res[1];

        if (res[1]==undefined) {
             document.getElementById("persona_id").value="";
        document.getElementById("txtdocumento").value="";
        };
       
    }
    </script>