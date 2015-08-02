$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: "autocompletar_usuario.php",
    data: dataString,
    cache: false,
    success: function(html)
    {
    $("#result").html(html).show();
    }
    });
}return false;    
});

$("#result").click(function(e){ 
   // alert("hola");
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid').val(decoded);

    var $id = $clicked.find('.id').html();
    var dec = $("<div/>").html($id).text();
    $('#id').val(dec);
});
$(document).click(function(e){ 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search")){
    $("#result").fadeOut(); 
    }
});
$('#searchid').click(function(){
    $("#result").fadeIn();
});
});
