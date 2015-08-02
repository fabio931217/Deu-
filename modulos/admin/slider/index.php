<style type="text/css">
    .even-row
    {
        background-color:#eee;
    }
</style>
<script type="text/javascript">
    var menu = "<?php echo $_GET['_menu'] ?>";

    $(document).ready(function(e) {
        $("#formulario").validate({
            errorLabelContainer: $("#formulario div.error"),
            submitHandler: function() {
                return false;
            },
            rules:
                    {
                        file: {required: true},
                        posicion: {required: true, digits: true},
                        descripcion: {required: true}
                    }
        });
    });



    function agregar()
    {
        document.getElementById("formulario").reset();
        dialogo('dialog', 'Agregar imagen', 450);
        $('#btn_aceptar').unbind('click');
        $("#btn_aceptar").click(function()
        {
            if (!validar())
                return;
            document.getElementById("subir").value = "S";
            document.getElementById("formulario").submit();
            document.getElementById("subir").value = "N";
        });

    }

    function eliminar()
    {
        var chk = $("input:checked");
        if (chk.length == 0)
        {
            alert("Debe seleccionar primero una imagen.");
        }
        else
        {
            if (confirm("Realmente desea eliminar la imagen seleccionada") == true)
            {
                $.post("?_tipo=json&_accion=eliminar&_menu=" + menu, "id=" + chk[0].value, function(data) {
                    alert("Imagen eliminada con exito.");
                    window.top.location.reload();
                });
            }
        }

    }
</script>

<br/>
<div style="width:900px; margin:auto">
    <div class="titulo">SLIDER (IMAGENES)</div>
    <table class="gDiv" style="width:100%; border-collapse:collapse" >
        <tr class="hDiv">
            <th style="width:40px"></th>
            <th style="width:150px; text-align:left">IMAGEN</th>
            <th style="text-align:left">DESCRIPCIÓN</th>
        </tr>
        <?php
        $sql = "SELECT * FROM slider ORDER BY posicion";
        $rs = $db->query($sql);

        while ($rw = $db->fetch_assoc($rs)) {
            $clase = ($clase == "odd-row") ? "even-row" : "odd-row";
            ?>
            <tr class="<?php echo $clase ?>">
                <td>
                    <input type="radio" name="id" value="<?php echo $rw['id'] ?>" />
                </td>
                <td>
                    <img style="width:250px" src="<?php echo $rw['ruta'] ?>" />
                </td>
                <td valign="top">
                    <b>Descripción:</b> <?php echo $rw['descripcion'] ?>
                    <br/> 
                    <b>Posición</b> <?php echo $rw['posicion'] ?>
                </td>
            </tr>
            <?php
        }
        ?>


    </table>
    <div style="height:10px"></div>
    <div style="text-align:right">
        <input type="button" value="Agregar"  onclick="agregar();"/>
        <input type="button" value="Eliminar" onclick="eliminar()" />
    </div>
</div>
<br/>

<div id="dialog" style="display:none; overflow:hidden">
    <form id="formulario" target="if_subir" method="post" 
          enctype="multipart/form-data" 
          action="?_menu=<?php echo $_GET['_menu'] ?>&_accion=subirArchivo&_tipo=json">

        <input type="hidden" name="subir" id="subir" />
        <table style="width:100%">
            <tr>
                <td class="tdi">Id</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  id="id" name="id" value="(Automatico)" readonly disabled="disabled"/>
                </td>
            </tr>

            <tr id="tr_file"> 
                <td class="tdi">Imagen</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  type="file" name="file" id="file" />
                </td>            
            </tr>

            <tr>
                <td class="tdi">Posición</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input  id="posicion" name="posicion" value=""/>
                </td>
            </tr>

            <tr> 
                <td  colspan="3">Descripción</td>
            </tr>
            <tr>
                <td  colspan="3">
                    <textarea id="descripcion" name="descripcion" style="resize:none; width:440px; height:40px"></textarea>
                </td>            
            </tr>

        </table>

        <iframe style="display:none" id="if_subir" name="if_subir" style="width:600px; height:80px"></iframe>
        <div class="error"></div>


        <div style="border-top:1px solid #ccc; text-align:left; padding-top:5px; margin-top:5px; padding-bottom:5px"> 
            <b>NOTA: </b> La imagen a subir debe estar en formato JPG, tener un ancho de 644 pixeles, un alto de 300 pixeles y un tamaño máximo de 250 Kb.
        </div>    

        <div style="border-top:1px solid #ccc; text-align:right; padding-top:5px; margin-top:5px; padding-bottom:5px">
            <input type="button" value="Aceptar" id="btn_aceptar" />
            <input type="button" value="Cancelar"  onclick="$('#dialog').dialog('destroy')" />
        </div>

    </form>
</div>