<script type="text/javascript" src="js/registrar_asistencia.js"></script>

<div class='ui-state-highlight ui-corner-all' style="padding: 0.7em;display:none" id="existe">
            <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                <strong>Informacion:</strong>  <p id="error"></p>   </p>
</div>
<div style="width:900px;min-height:150px; margin:auto;">



<div style="width:140px;float:left">
   <img src="img/iconos/asistencia2.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Registrar Asistencia</th>
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
            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Datos de usuario</th>
            </tr>

            <tr> 
                <td class="tdi">Documento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                 <input type="hidden" name="persona_id" id="persona_id"  value="" title="Documento" maxlength="30"  />
               
                    <input type="text" name="txtdocumento" id="txtdocumento"  value="" title="Documento" maxlength="30" onblur="verificar_usuario()"/>
               
                </td>            
            </tr> 
            <tr> 
                <td class="tdi">Institucion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbminstitucion" name="cbminstitucion" title="Institucion" onChange="cargarDependencia()" style="width:415px">
                        <?php
                        llenar_combo("SELECT * FROM institucion ORDER BY nombre ", true);
                        ?>
                    </select>
                    <button type="button" style="width:5px" onclick="agregar_institucion()">Agregar</button>
                </td>            
            </tr>              
             <tr> 
                <td class="tdi">Dependencia</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmdependencia" name="cbmdependencia" title="Dependencia" style="width:415px">
                        <?php
                        //llenar_combo("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre", true);
                        ?>
                    </select>
                    <button  type="button" style="width:5px" onclick="agregar_dependencia()">Agregar</button>
                </td>            
            </tr>    
             <tr> 
                <td class="tdi">Funcion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmfuncion" name="cbmfuncion" title="Funcion" class="chosen-select">
                        <?php
                        llenar_combo("SELECT * FROM funcion WHERE codigo!=1", true);
                        ?>
                    </select>
                </td>            
            </tr>
            


        </table>




        <div class="error"></div>
        <div class="acciones">
		<input type="button" name="accion" value="Registrar" onclick="registrar()" class="accion-registrar" />

        </div>

    </form>
</div>
</div>





<div id="dialogo" style="display:none; max-width:">

    <form id="formulario_resgistrar">
    <center>
        <table style="width:80%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">DOCUMENTO</th>
            </tr>
 

            <tr> 
                <td class="tdi">Tipo identificación</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmidentificacion" name="cbmidentificacion" title="Tipo identificación" >
                        <?php
                        llenar_combo2("SELECT * FROM general.tipoidentificacion", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Identificacion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="number" name="txtidentificacion" id="txtidentificacion"  value="" title="Identificacion" maxlength="30"/>
                </td>            
            </tr>

           
   <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">INFORMACION PERSONAL</th>
    </tr>

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtnombre" id="txtnombre"  value="" title="Nombre" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Primer Apellido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtp1" id="txtp1"  value="" title="Primer Apellido" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Segundo Apellido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtp2" id="txtp2"  value="" title="Segundo Apellido" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Sexo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmsexo" name="cbmsexo" title="Sexo" >
                        <?php
                        llenar_combo2("SELECT * FROM general.sexo", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

           
   <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">CORREOS ELECTRONICOS</th>
    </tr>

<tr>
                <td class="tdi">Correo 1</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="correo1" name="correo1" title="Correo 1" maxlength="60"/>  
                </td>
            </tr>

         

        </table>
</center>
      
  <div class="error"></div>
        <div class="acciones">

        <input type="button" id="accion" name="accion" value="Aceptar"  onclick="RegistrarUsuario()">

        </div>
    </form>
</div>




<div id="dialogo_institucion" style="display:none; max-width:">
    <form id="formulario_institucion">
        <table style="width:100%">
 

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre_institucion" name="nombre_institucion" title="Nombre Institucion" maxlength="100" value="" />
                </td>            
            </tr>

        </table>

        <div class="error"></div>
        <div class="dlg-acciones">
            <input type="button" id="btn_aceptar" value="Aceptar" onclick="RegistrarInstitucion()" />
         </div>

    </form>
</div>


<div id="dialogo_dependencia" style="display:none; max-width:">
    <form id="formulario_dependencia">
        <table style="width:100%">
 
            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre_dependencia" name="nombre_dependencia" title="Nombre Dependencia" maxlength="50" value="" />
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Institucion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="institucion_id" name="institucion_id" title="Institucion">
                        <?php llenar_combo("SELECT codigo, nombre FROM institucion ORDER BY nombre",true); ?>
                    </select>                
                </td>
            </tr>

        </table>

        <div class="error"></div>
        <div class="dlg-acciones">
            <input type="button" id="btn_aceptar" value="Aceptar" onclick="RegistrarDependencia()" />
           
        </div>

    </form>
</div>