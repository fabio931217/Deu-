<?php 
session_start(); 
// genero el codigo 
$ranStr = md5(microtime()); 
$ranStr = substr($ranStr, 0, 6);
//le asigno a la session el valor de mi captcha
$_SESSION['cap_code'] = $ranStr;

 ?>

<script type="text/javascript">
 

                        
    function aceptar()
    {
 
confirmar("¿Desea guardar los datos?",continuar);

    }

function continuar() {
           $.post(page_root + "aceptar", $("#formulario").values(), function(data) {
           // alerta(data);
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
             alerta(r.msg);
                
               
            } else
            {

                if (r.msg==1) 
                    {
                        alerta("Registrado con exito");
                        recargar_pagina(3000);
                        
                    }
                    else
                        {
                             alerta(r.msg);
                             $("#sql").html(r.msg);
                             $("#cap").html(r.cap);

                        }       
            }
        });
}
 function verificar_usuario()
    {

         $("#dialogo").dialog({
            width: 760,
            height: 460,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
         
     var id = document.getElementById("txtidentificacion").value;
       
            $.get(page_root + "verificar_usuario", "txtidentificacion=" + id, function(data) {
            var r = jQuery.parseJSON(data);
            //alert(r.nombre);
            if(r.nombre>0)
            {
                alerta("Usuario ya existe");
                $("#existe,#existe2").css({"display":"block","font-size":"200%"});
                $("#accion").hide();
            }else{$("#existe,#existe2").css({"display":"none","font-size":"200%"});  $("#accion").show();}
         
        });
        
    }
</script>
    <script>
    jQuery(document).ready(function($) {
        $("#formulario").progression({
          tooltipWidth: '200',
          tooltipPosition: 'right',
          tooltipOffset: '50',
          showProgressBar: true,
          showHelper: true,
          tooltipFontSize: '14',
          tooltipFontColor: 'fff',
          progressBarBackground: 'fff',
          progressBarColor: '6EA5E1',
          tooltipBackgroundColor:'a2cbfa',
          tooltipPadding: '10',
          tooltipAnimate: true
        });

    });

    </script>


<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;display:none" id="existe">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Advertencia:</strong>  Usuario ya existe   </p>
</div>


<div style="width:900px;min-height:160px; margin:auto; padding-top:10px;">



<div style="width:140px;float:left">
   <img src="img/iconos/registro.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">DOCUMENTO</th>
            </tr>
 

            <tr> 
                <td class="tdi">Tipo identificación</td>
                <td class="tdc">:</td>
                <td class="tdd">
               
                    <select id="cbmidentificacion" name="cbmidentificacion" title="Tipo identificación" class="chosen-select">
                        <?php
                        llenar_combo("SELECT * FROM tipoidentificacion", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Identificacion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                 
                    <input data-progression type="text" data-helper="Help users through forms by prividing helpful hinters" name="txtidentificacion" id="txtidentificacion" value="" title="Identificacion" maxlength="30"  onblur="verificar_usuario();"/>
                       
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Fecha Expedicion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                
                    <input data-progression type="date" name="fecha_exp" id="fecha_exp" data-helper="Ingrese Fecha de Expedicion" value="" title="Fecha Expedicion" maxlength="30"/>
               
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Municipio expedicion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                             <select  id="muni_exp" name="muni_exp" title="Municipio Expedicion" class="chosen-select">
                        <?php
                        llenar_combo("SELECT m.codigo as codigo, CONCAT_WS (' : ', d.nombre ,m.nombre) as nombre FROM general.municipios m, general.departamentos d WHERE m.depto=d.codigo", true);
                        ?>
                 
                    </select>
                </td>            
            </tr>

   <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">INFORMACION PERSONAL</th>
    </tr>

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="text" name="txtnombre" id="txtnombre" data-helper="Ingrese Nombre"  value="" title="Nombre" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Primer Apellido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtp1" id="txtp1"  data-helper="Ingrese Primer Apellido" value="" title="Primer Apellido" maxlength="30"/>
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
                <td class="tdi">Fecha Nacimiento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="date" name="fecha_nac" id="fecha_nac"  value="" title="Fecha Nacimiento" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Sexo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select  id="cbmsexo" name="cbmsexo" title="Sexo" class="chosen-select">
                        <?php
                        llenar_combo("SELECT * FROM general.sexo", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Municipio Nacimiento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                   
               <select   id="muni_naci" name="muni_naci" title="Municipio Nacimiento" class="chosen-select">
                        <?php
                        llenar_combo("SELECT m.codigo as codigo, CONCAT_WS (' : ', d.nombre ,m.nombre) as nombre FROM general.municipios m, general.departamentos d WHERE m.depto=d.codigo", true);
                        ?>
                    </select>

                </td>            
            </tr>
             <tr> 
                <td class="tdi">Municipio Residencia</td>
                <td class="tdc">:</td>
                <td class="tdd">
                   
               <select  id="muni_res" name="muni_res" title="Municipio Residencia" class="chosen-select">
                        <?php
                        llenar_combo("SELECT m.codigo as codigo, CONCAT_WS (' : ', d.nombre ,m.nombre) as nombre FROM general.municipios m, general.departamentos d WHERE m.depto=d.codigo", true);
                        ?>
                    </select>

                </td>            
            </tr>
             <tr> 
                <td class="tdi">Direccion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="text" name="txtdireccion" id="txtdireccion"  value="" title="Direccion" maxlength="30"/>
                </td>            
            </tr>
   <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">CORREOS ELECTRONICOS</th>
    </tr>

<tr>
                <td class="tdi">Correo 1</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="text" id="correo1" name="correo1" title="Correo 1" maxlength="60"/>  
                </td>
            </tr>

            <tr>
                <td class="tdi">Correo 2 (opcional)</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="email" id="correo2" name="correo2" title="Correo 2" maxlength="60"/>  
                </td>
            </tr>            
                        

       <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">NUMEROS TELEFONICOS</th>
    </tr>
            <tr>
                <td class="tdi">Telefono 1</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select  id="tipotelefono1" name="tipotelefono1" title="Tipo telefono 1" style="width:159px" class="chosen-select">
                         <?php
                        llenar_combo("SELECT * FROM general.lugartel", true);
                        ?>
                    </select>
                    <input type="number"  id="telefono1" name="telefono1" title="Telefono 1" maxlength="15" style="width:300px"/>  
                </td>
            </tr>

            <tr>
                <td class="tdi">Telefono 2 (opcional)</td>
                <td class="tdc">:</td>
                <td class="tdd">

                    <select  id="tipotelefono2" name="tipotelefono2" title="Tipo telefono 2" style="width:159px" class="chosen-select">
                         <?php
                        llenar_combo("SELECT * FROM general.lugartel", true);
                        ?>
                            </select>
                                    
                
                    <input  type="number" id="telefono2" name="telefono2" title="Telefono 2" maxlength="15"  style="width:300px"/>  
                </td>
            </tr>
            
            <tr>
                <td colspan="3" style="font-size:14px; font-weight:bold; text-align:center; padding:5px">
                CLAVE DE INGRESO</td>
            </tr>
            <tr>
                <td class="tdi">Clave</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="password"  id="clave1" name="clave1" title="Clave" maxlength="12" />  
                </td>
            </tr>

            <tr>
                <td class="tdi">Repetir clave</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="password"  id="clave2" name="clave2" title="Repetir clave" maxlength="12"/>  
                </td>
            </tr>

<tr> 
                <td class="tdi">Pregunta secreta</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select  id="cbmprgunta" name="cbmpregunta" title="pregunta" class="chosen-select">
                        <?php
                        llenar_combo("SELECT * FROM preguntas_secretas", false);
                        ?>
                    </select>
                </td>            
            </tr>        
  <tr>
                <td class="tdi">Respuesta</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="text"  id="respuesta" name="respuesta" title="Respuesta" maxlength="29"/>  
                </td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:14px; font-weight:bold; text-align:center; padding:5px">
                VERIFICACIÓN</td>
            </tr>            
             
             <tr>
                <td colspan="3" style="text-align:center; border:1px solid silver">

                <div id="cap" style="margin:auto; font-weight: bold;font-size: 180%; font-style: bold;width:30%; padding:10px;background-image: url('img/cap.png');"><?php echo $_SESSION["cap_code"] ?></div>
          
                </td>
            </tr>  
            
            <tr>
                <td class="tdi">Texto de la Imagen</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    
                    <input  type="text" title="Texto de la Imagen" name="captcha" id="captcha" value='' />
                    
                </td>
            </tr>
           

        </table>

       
        <div class="acciones">
	<input  type="button" id="accion" name="accion" value="Aceptar"   onclick="aceptar()" />

        </div>

    </form>


</div>
</div>
<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;display:none" id="existe2">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Advertencia:</strong>  Usuario ya existe   </p>
</div>