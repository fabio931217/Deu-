<?php
//session_destroy();
?>
<script type="text/javascript">



            $(function() {
        alerta("hol");
            });
    function iniciar()
    {
        $.post(page_root + "iniciar", $("#formulario").values(), function(data) {
            try
            {
                var r = jQuery.parseJSON(data);
                if (r.error == true)
                {
                    
                     alerta(r.msg);
                 $("#error").html(r.msg);
                 $("#existe2").css({"display":"none"});
                 $("#existe").css({"display":"block"});
                }
                else
                {
                    window.location.href = web_root;
                }
            } catch (ex) {
                alerta('Error desconocido.');
            }
        });
    }
</script>


<div style="width:900px;min-height:160px; margin:auto; padding-top:120px;">



<div style="width:140px;float:left">
   <img src="img/iconos/login.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>
<div >
    <div style="width: 450px;  margin: auto">

        <form id="formulario" method="POST"  >

            <table cellpadding="0" style="width:100%" border="0">
                <tbody>
                    <tr class="ui-widget-header" style="height:22px">
                        <th  colspan="3">
                            INICIAR SESIÓN
                        </th>
                    </tr>  


                    <tr>
                        <td class="tdi">Identificación</td>
                    </tr>
                    <tr>
                       <td class="tdd">
                            <input type="text" id="usuario" name="usuario" maxlength="15"  value="" title="Identificación"
                                   style= "width:100%; border:1px silver solid"/>
                        </td>
                    </tr>

                    <tr>
                        <td class="tdi">Clave</td>
                    </tr>

                     <tr>
                     <td class="tdd">
                            <input type="password"  id="clave" name="clave" value="" maxlength="12"  title="Clave"
                                   style="width:100%; border:1px silver solid" />
                        </td>
                    </tr>

                    <tr>
                        <td colspan="1" style="border-top:1px solid silver; text-align: right"> 
                              <a style="float:left;margin-top:4px;color:#000;text-decoration:none" href="restaurar_contrasena">¿No puedes ingresar...?</a>
                            <input type="button"  value="Entrar"  onclick="iniciar()" />

                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="error" style="display:none !important"></div>
        </form>

    </div>
</div>
<div id="existe" class="alert-box error" style="display:none"><span>error: </span><p id="error"> </p></div>
<div id="existe2" class="alert-box success" style="display:none"><span>Exito: </span><p id="error2"> </p></div>
</div>
