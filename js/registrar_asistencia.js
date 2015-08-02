function cargarInstitucion()
 {
        
        cargarCombo(page_root + "cargarInstitucion", "formulario", "cbminstitucion", true);
       
 }
 function cargarEventos()
 {
        
        cargarCombo(page_root + "cargarEventos", "formulario", "cbmevento", true);
       
 }
  function cargarDependencia()
 {
       
        cargarCombo(page_root + "cargarDependencia", "formulario", "cbmdependencia", true);
       
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

$(document).ready(function(e) {
               
        $("#txtdocumento").autocompletar2(page_root + "listarPersonas", {
            form: "formulario",
            inputId: "persona_id",
            minLength: 1});        
    });
                        
    function registrar()
    {
                bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
        $.post(page_root + "registrar", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                if (r.e==1) 
            { $("#error").html(r.msg);
                 $("#existe").css({"display":"block","font-size":"200%"});
             }else{                bootbox.alert(r.msg)};

            } else
            {
                bootbox.alert(r.msg);
                //recargar_pagina(4000);
            }
        });
    }

});
    }

    function RegistrarUsuario()
    {
         bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
        $.post(page_root + "RegistrarUsuario", $("#formulario_resgistrar").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                bootbox.alert(r.msg);
                            
            } else
            {
                bootbox.alert("Registrado con exito");
                 $("#error").html(r.msg);
                 $("#existe").css({"display":"block","font-size":"200%"});
                jQuery('#dialogo').dialog('close');
                 setTimeout(function(){$("#existe").css({"display":"none","font-size":"200%"});}, 6000);



            }
        });
 }

});
    }
    function RegistrarDependencia()
    {
      
 bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
        $.post(page_root + "RegistrarDependencia", $("#formulario_dependencia").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                bootbox.alert(r.msg);
            } else
            {
                
                cargarInstitucion();
                bootbox.alert(r.msg);
                jQuery('#dialogo_dependencia').dialog('close');
            }
        });

  }

});
    }

    function RegistrarInstitucion()
    {

         bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
        $.post(page_root + "RegistrarInstitucion", $("#formulario_institucion").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                bootbox.alert(r.msg);
            } else
            {
               
                cargarInstitucion()
                 bootbox.alert(r.msg);
                jQuery('#dialogo_institucion').dialog('close');
            }
        });
 }

});

    }

 function verificar_usuario()
    {
        
       

     var id = document.getElementById("persona_id").value;
       //alert(id);
            $.get(page_root + "verificar_usuario", "txtidentificacion=" + id, function(data) {
            var r = jQuery.parseJSON(data);
         //   alert(r.nombre);
            if(r.nombre==0)
            {
               bootbox.confirm("Usuario no existe ¿Desea registrarlo?", function(result) {

if (result==true) 
{
              

                 $("#dialogo").dialog({
            width: 760,
            title:"Registrar Usuario",
            //height: 460,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });

}
 });
        }

       
        
});
    }

    function agregar_dependencia() {
         $("#dialogo_dependencia").dialog({
            width: 760,
            title:"Registrar Dependencia",
            //height: 460,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
            
    }
    function agregar_institucion() {
         $("#dialogo_institucion").dialog({
            width: 760,
            title:"Registrar Institucion",
            //height: 460,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
            
    }
