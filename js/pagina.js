$(document).ready(function(e) {
    
	
    $("button, input:submit, input:reset, input:button,  .button").button();
    $("button, input:submit, input:reset, input:button,  .button").css("min-width", "90px");
 
    $(".boton-busqueda").click(function() {
        $(".div-form-busqueda").toggle("blind", 200);
    });
    
    $("input, select, textarea").change(function(e){
      $(e.target).removeClass("error");  
    });
    
	
    //$(".div-form-busqueda").show();
   /*
    $('select').each( function(ind,obj){
        if(obj.value=="") {
            $(obj).addClass("vacio");
        }
    });
 
    $("select").change(function(e){
        if(e.target.value=="") {
            $(e.target).addClass("vacio");
        } else
        {
            $(e.target).removeClass("vacio");
        }
    });
    */
    setTimeout("activarSesion()", 30000);
	
});


function activarSesion()
{
    //$.get("<?php echo WEB_ROOT ?>sesion.php");
    //setTimeout("activarSesion()",30000);
}