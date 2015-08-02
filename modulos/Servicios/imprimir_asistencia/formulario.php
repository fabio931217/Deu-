<script type="text/javascript">

function cargarEventos()
 {
        
        cargarCombo(page_root + "cargarEventos", "formulario", "txtbuscar", true);
       
 }

  function cargarAgendas()
 {
   //alert("hola");
    $.post(page_root + "cargarAgendas", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
           //alert(r);
            $("#cbmagenda").html(r);
         });
       
 }
    $(document).ready(function()  {
        
        $("#formulario").submit(function() {
            $.ajaxSetup({async: false});
            $.post(page_root + "validar", $("#formulario").values(), function(data) {
                var r = jQuery.parseJSON(data);
                if (r.error == true)
                {
                    for (ind in r.bad_fields)
                    {
                        $("#" + r.bad_fields[ind]).addClass("error");
                    }
                    bootbox.alert(r.msg);
                } else {
                    return true;
                }
            });

            return false;
        });
        
    });
</script>

<a class="items" style="width:600px; margin:auto; margin-top:10px;margin-bottom:10px">
    <div class="icono">
        <img src="img/iconos/impresion.png" alt="" style="width:90px" />
    </div>
    <div class="texto">
        <span style="text-align:left">Imprimir asistencia</span>
        <div>Desde esta opci&oacuten podrá imprimir todas las planillas de asistencia en varios formatos, de las asistencias de eventos.</div>
    </div>
</a> 

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" method="post"  target="_blank" 
        action="<?php echo PAGE_ROOT . "mostrar" ?>">
        <table style="width:100%">
            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Imprimir Asistencia</th>
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
                <td class="tdi">Acto</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="txtbuscar" name="txtbuscar" title="Acto" onChange="cargarAgendas()">
                        <?php
                     //   llenar_combo("SELECT * FROM acto", true);
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
                            

            <tr> 
                <td class="tdi">Tipo de Reporte</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="tipo" name="tipo" title="Tipo de Reporte">
                       <option value="0">RELACION GENERAL</option>
                        <?php
                        llenar_combo2("SELECT * FROM general.sexo", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Dependencia</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmdependencia" name="cbmdependencia" title="Dependencia" Class="chosen-select">
                        <option value="0">TODAS</option>
                        <?php
                                                llenar_combo("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre", true);
                        ?>
                    </select>
                </td>            
            </tr>                             
                            
            <tr> 
                <td class="tdi">Ordenar Por</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmordenar" name="cbmordenar">
                        <option value="0">NOMBRE(S)</option>
                        <option value="1">APELLIDOS</option>
                        <option value="2">TIPO DOCUMENTO</option>
                        <option value="3">SEXO</option>
                        <option value="4">INSTITUCION</option>
                        <option value="5">DEPENDENCIA</option>
                        <option value="6">FUNCION</option>

                    </select>
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Formato</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="formato" name="formato">
                        <option value="PDF">Documento PDF</option>
                        <option value="XLS">Documento de Excel</option>
                        <option value="DOC">Documento de Word</option>
                        <option value="HTML">Visualizar en el navegador Web</option>
                    </select>
                </td>            
            </tr>
        </table>

        <div class="acciones">
            <input type="submit" value="Mostrar" class="accion-mostrar-reporte"/>
        </div>
    </form>
</div>
