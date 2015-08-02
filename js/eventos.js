
$(function(){
    $("div.holder2").jPages({
      containerID : "agenda-detalles",
      previous : "←",
      next : "→",
      perPage : 8,
      delay : 8
    });
  });


$(function(){
    $("div.holder").jPages({
      containerID : "cuerpo-detalles",
      previous : "←",
      next : "→",
      perPage : 10,
      delay : 10
    });
  });






function cambiocombo()
{
  if ($("#cbmbuscar").val()==6)
  {
    $("#txtbuscar").hide();
    $("#fechabuscar").show();

  }
  else
  {
    $("#txtbuscar").show();
    $("#fechabuscar").hide();
  }
}
    function ocultar()
    {
      
      if ($("#btnocultar").val()=="Ocultar Eventos recientes")
      {

        $("#izquierda").slideUp();
        $("#btnocultar").val("Ver eventos recientes");
      }
      else
      {
        $("#izquierda").slideDown();
        $("#btnocultar").val("Ocultar Eventos recientes");
      }

    }
            $(document).ready(function(){
              $("#dialogo").hide();
             $("#reporte tr:odd").addClass("odd");
           // $("#reporte tr:not(.odd)").hide();
           // $("#reporte tr:first-child").show();
            
            $(".arrow").click(function(){

          $("#dialogo").dialog({
            width: 760,
            height: 460,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
      
            });
        });

$(document).ready(function(){

$("#fechabuscar").hide();


$('#cbmbuscar').change(function() {

//alert($('#cbmbuscar').val();

 if ($("#cbmbuscar").val()==6)
  {
    $("#txtbuscar").hide();
    $("#fechabuscar").show();

  }
  else
  {
    $("#txtbuscar").show();
    $("#fechabuscar").hide();
  }
      });

});

function myFunction(x)
{
  
//alert("Row index is: " + x.rowIndex);
//alert(document.getElementById("datos").rows[x.rowIndex].cells[0].innerText);

var codigo = document.getElementById("reporte").rows[x.rowIndex].cells[0].innerText;
//$("#txtcodigo").val(document.getElementById("reporte").rows[x.rowIndex].cells[0].innerText);
//$("#txtnombreevento2").val(document.getElementById("reporte").rows[x.rowIndex].cells[1].innerText);
//$("#descrip").val(document.getElementById("reporte").rows[x.rowIndex].cells[3].innerText);
//$("#objetiv").val(document.getElementById("reporte").rows[x.rowIndex].cells[4].innerText);

//alert(codigo);



}


function imprimir_agenda(argument) {
  var id= $("#txtcodigo").val();
  alert(id);
  $.ajax({
            url:"descargar_agendas.php",
            type: "POST",
            data:"op="+id,
            success: function(opciones){
              //$(".cbmfuncion").html(opciones);
              alert(opciones);
            }
          })

}