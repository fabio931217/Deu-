<style type="text/css">
    ul, ol {
    list-style: none;
}


a {
    color: #004756;
    text-decoration: underline;
  
}


.gridster {
    width: 100%;
    margin:auto;
    padding-left: 0px;
    margin-bottom: 50px;
    margin-top: 10px;
}


.gridster ul li:hover {
    box-shadow: 0px 0px 12px;
    cursor: pointer;
}
</style>
<div  style="min-height:300px;width:900px; margin:auto; margin-top:20px;border:none" >
   
<link rel="stylesheet" type="text/css" href="js/jquery.gridster.min.css">
<link rel="stylesheet" href="css/style.css">

  

        <div class="gridster">
         
          <ul>
            <li data-row="1" data-col="1" data-sizex="2" data-sizey="1" class="dato1" ><a href="telefonos"><img src="img/nuevo_tel.png"> </a> </img></li>
          
            
            <li data-row="1" data-col="2" data-sizex="2" data-sizey="2" > <a href="datos-personales"> <img src="img/agregar_escenario.png"> </a> </img></li>

            <li data-row="1" data-col="4" data-sizex="1" data-sizey="1" data-max-sizex="1" data-max-sizey="1"><a href="foto_perfil"><img src="img/agregar_acto.png"> </img></li>
            <li data-row="2" data-col="4" data-sizex="2" data-sizey="1" ><a href="email"><img src="img/agregar_dependencia.png"></li>

            <li data-row="2" data-col="5" data-sizex="1" data-sizey="1" class="dato1" ><a href="clave"><img src="img/nuevo_sexo.png">  </img></li>
           
        
          </ul>

        </div>

</div>

<script src="js/jquery.gridster.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  var gridster;

  $(function(){

    gridster = $(".gridster > ul").gridster({
        widget_margins: [8, 5],
        widget_base_dimensions: [140, 140],
        min_cols: 6,
        resize: {
            enabled: true
        }
    }).data('gridster');

  });
</script>

