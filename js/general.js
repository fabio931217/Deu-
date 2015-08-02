var color_input_bloqueado = "#e5e5e5";

function dialogo(id, titulo, ancho)
{

    id = id.replace("#", "");

    try
    {
        $("#" + id).dialog("destroy");
    }
    catch (e) {
    }
    $("#" + id).dialog(
            {
                modal: true,
                minHeight: 120,
                width: ancho,
                closeOnEscape: false,
                title: titulo,
                resizable: false,
                open: function() {
                    //Codigo para centrar manualmente, el centrado por defecto del jQueryUI no centra del todo bien
                    //$(this).dialog('option', 'position',"top");
                    var t = $(this).parent(), w = $("body");

                    var left2 = $(w).width() / 2 - $(t).width() / 2;
                    left2 = parseInt(left2);

                    $(t).css("left", left2 + "px");

                    var top2 = $(w).height() / 2 - $(t).height() / 2;
                    top2 = parseInt(top2);

                    $(t).css("top", top2 + "px");
                }
            });

}

function stripHTML(cadena)
{
    cadena = cadena.replace(/<[^>]+>/g, '\n');
    cadena = cadena.replace(/\n\n/g, '\n');
    return jQuery.trim(cadena);
}



function cargar_input(id, url, param)
{
    var ip;
    if (ip = document.getElementById(id))
    {
        ip.value = "Cargando...";
        var xhr = post(url, param);
        ip.value = xhr.responseText;
    }
}




function URLDecode(encodedString)
{
    var output = encodedString;
    output = output.replace(/\+/g, '%20');
    var binVal, thisString;
    var myregexp = /(%[^%]{2})/;
    while ((match = myregexp.exec(output)) != null
            && match.length > 1
            && match[1] != '')
    {
        binVal = parseInt(match[1].substr(1), 16);
        thisString = String.fromCharCode(binVal);
        output = output.replace(match[1], thisString);
    }
    return output;
}

function URLEncode(str)
{
    var histogram = {}, histogram_r = {}, code = 0, tmp_arr = [];
    var ret = str.toString();

    var replacer = function(search, replace, str)
    {
        var tmp_arr = [];
        tmp_arr = str.split(search);
        return tmp_arr.join(replace);
    };
    // The histogram is identical to the one in urldecode.  
    histogram['!'] = '%21';
    histogram['%20'] = '+';
    // Begin with encodeURIComponent, which most resembles PHP's encoding functions  
    ret = encodeURIComponent(ret);
    for (search in histogram)
    {
        replace = histogram[search];
        ret = replacer(search, replace, ret) // Custom replace. No regexing  
    }
    // Uppercase for full PHP compatibility  
    return ret.replace(/(\%([a-z0-9]{2}))/g, function(full, m1, m2) {
        return "%" + m2.toUpperCase();
    });
    return ret;
}



/******************************************************************/


function validar(form_id)
{

    if (!form_id)
        form_id = "formulario";

    $("#" + form_id + " div.error").html("");

    if ($("#" + form_id).valid() == false)
    {
        var html = $("#" + form_id + " div.error").html();
        alert("Por favor revise los siguientes campos: \n\n" + stripHTML(html));
        return false;
    }
    return true;
}

function bloquear_entradas(formulario)
{
    $(".select2-offscreen").select2("enable", false);
    $("#" + formulario).find("input:text, select, textarea").each(function(index, element) {
        element.disabled = true;
    });
}

function bloquear_no_modifibles(formulario)
{
    $(".no-modificable").attr("disabled", true);
}

function desbloquear_entradas(formulario)
{
    $("#" + formulario).find("input:text, select, textarea").each(function(index, element) {
        element.disabled = false;
    });
    $(".select2-offscreen").select2("enable", true);
}


function asignar_json(formulario, s_json)
{
    var datos = jQuery.parseJSON(s_json); //Convertir los datos a una estructura
    var campo;
    for (campo in datos) //Recorrer estructura para asignar los datos
    {
        asignar_valor(formulario, campo, datos[campo]);
    }
}

function asignar_valor(formulario, nombre, valor)
{
    var obj = $("#" + formulario).find("*[name=" + nombre + "]");
    if (obj.length == 0)
    {
    }
    else if (obj.length == 1)
    {
        if ($(obj[0]).hasClass("tinymce"))
        {
            //tinyMCE.get(e.name).getContent();
            console.log(obj[0]);
            console.log(obj[0].name);
            tinyMCE.get(obj[0].name).setContent(valor);
        }
        else if ($(obj).hasClass("select2-offscreen"))
        {
            $(obj).select2("data", valor);
        }
        else
        {
            obj[0].value = valor;
        }
    }
    else
    {
        for (i = 0; i < obj.length; i++)
        {
            if (obj[i].value == valor)
                obj[i].checked = true;
        }
    }
}


function cargarCombo(url, id_formulario, id_combo, blanco, predeterminado, funcion)
{
    var cb = document.getElementById(id_combo);
    cb.options.length = 0; //Limpiar el combo
    cb.options.add(new Option("Cargando...", "Cargando..."));

    $.ajax({
        type: "POST",
        url: url,
        data: jQuery("#" + id_formulario).serialize(), // Pasar todos los datos del formulario como parametro
        success: function(data) //funcion que se llama al terminar la petición AJAX
        {
            cb.options.length = 0; //Limpiar el combo
            if (blanco == true)
                cb.options.add(new Option("", ""));// Primera opcion en blanco

            var json = jQuery.parseJSON(data);  //Pasar los datos al formato JSON, que es el que interpreta javascript
            for (i = 0; i < json.length; i++)
            {
                cb.options.add(new Option(json[i].nombre, json[i].codigo));
            }

            if (predeterminado)
                cb.value = predeterminado;
            if (funcion)
                funcion(cb, predeterminado);

        }
    });

}
