<script type="text/javascript">
 

                        
    function aceptar()
    {
       confirmar("¿Desea continuar?",continuar);
    }

    function continuar()
    {
      $.post(page_root + "aceptar", $("#formulario").values(), function(data) {
            
           //alerta(data) para ver el prev

            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
               alerta(r.msg);
                 $("#error").html(r.msg);
                 $("#existe2").css({"display":"none"});
                 $("#existe").css({"display":"block"});

            } else
            {
                alerta(r.msg);
                $("#error2").html(r.msg);
                $("#existe").css({"display":"none"});
                $("#existe2").css({"display":"block"});

                recargar_pagina(3000);
            }
        });
    }


</script>

<div class="alert-box error"><span>error: </span>escribir mensaje</div>
<div class="alert-box success"><span>exito: </span>escribir mensaje.</div>
<div class="alert-box warning"><span>advertencia: </span>escribir mensaje.</div>
<div class="alert-box notice"><span>noticia: </span>escribir mensaje.</div>