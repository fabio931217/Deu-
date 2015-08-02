
$(document).ready(function(e) {
         $(".ocultar,#ocultar").hide();
        $('#txtdocumento').autocomplete({
            source: function(request, response) {
            $.ajax({
            url: "auto_usuarios2.php",
            dataType: "json",
            data: {
              term : request.term,
              evento : $("#cbmevento").val()
             },
            success: function(data) {
                 response(data);
                  }
                  });
                  },
                  form: "formulario",
            inputId: "persona_id",
            minLength: 2});   
          
    });

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

      function cargarEventos()
 {

       
        cargarCombo(page_root + "cargarEventos", "formulario", "cbmevento", true);
  
 }
 function cargarDependencia()
 {
      var r =$("#cbmobjeto").val();
      //alert(r);

if (r==1)
 {
 $(".ocultar,#ocultar").hide();
 }

 else if (r==2)
 {

   var id =$("#persona_id").val();
   //alert(id);


    if (id=="")

{

alert("Ingrese usuario para ver sus dependencias");
$('#cbmobjeto > option[value=""]').attr('selected', 'selected');
document.getElementById("cbmdependencia").options.length = 0;

}

$.post(page_root + "cargarDependencias", $("#formulario").values(), function(data) {
           
//alert(data);
            var r = jQuery.parseJSON(data);
          // alert(r);
            $("#cbmdependencia").html(r);
         });

        $(".ocultar,#ocultar").show();
 }
 }