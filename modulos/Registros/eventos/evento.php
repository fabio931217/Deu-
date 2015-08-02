<script>
$(function() {  
auto();
});

function auto(){
   $(".usuario").autocomplete({
    source: "auto_usuarios.php",
    minLength: 3
  });   
}
</script>
 <script type="text/javascript" src="js/manipulacion.js"></script> 

<link href="css/smart_wizard2.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.smartWizard-2.0.min.js"></script>
<script type="text/javascript" src="js/validarregistrar_eventos.js"></script>
 
  
<script type="text/javascript">
 function comboEscenario()
    {
        $.get(page_root + "comboEscenario", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
            $(".cbmescenario").html(r);
         });
    }
     function comboHoras()
    {
        $.get(page_root + "comboHoras", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
            
            $(".cbmhora").html(r);
         });
    }

function comboFuncion()
    {
       $.get(page_root + "comboFuncion", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
            $(".cbmfuncion").html(r);
         });
    }
    function comboDependencia()
    {
        $.get(page_root + "comboDependencia", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
            $(".cbmdependencia").html(r);
         });
    }

    $(document).ready(function(){

              //  Wizard 1    
        $('#wizard1').smartWizard({transitionEffect:'fade',onFinish:onFinishCallback});
        //  Wizard 2
      
      function onFinishCallback(){
         
       validar();
      }   

      
  
        });
</script>


  <!-- development location, distribution location -->
 
  
<form id="frmeventos" >
<table align="center" border="0" cellpadding="0" cellspacing="0">
<tr><td>
        <div id="wizard1" class="swMain">
            <ul>
                <li><a href="#step-1">
                <span class="stepNumber">1</span>
                <span class="stepDesc">
                   Registrar evento<br />
                   <small></small>
                </span>
            </a></li>
                <li><a href="#step-2">
                <span class="stepNumber">2</span>
                <span class="stepDesc">
                   Registrar Organizadores<br />
                   <small></small>
                </span>
            </a></li>
                <li><a href="#step-3">
                <span class="stepNumber">3</span>
                <span class="stepDesc">
                   Programar agenda<br />
                   <small></small>
                </span>                   
             </a></li>
                <li><a href="#step-4">
                <span class="stepNumber">4</span>
                <span class="stepDesc">
                   Conclusiones<br />
                   <small></small>
                </span>                   
            </a></li>
            </ul>
        <div id="step-1">   
            <h2 class="StepTitle">Registrar evento</h2>
            


            <table width="80%" style="margin:auto;margin-top:100px">
              
               <tr>
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd" style="padding:0;">
                    <input type="text"  name="txtnombre" id="txtnombre" maxlength="200" style="width:100%" />
               
                </td>
            </tr>   
            
            <tr>
                <td class="tdi" style="width:145px">Descripcion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                <textarea id="descripcion" name="descripcion" style="height:70px;width:100%;border-radius:4px"></textarea>
                   
                </td>
            </tr>
            
             <tr>
                <td class="tdi" style="width:145px">Objetivos</td>
                <td class="tdc">:</td>
                <td class="tdd">
                <textarea id="objetivos" name="objetivos" style="height:70px;width:100%;border-radius:4px"></textarea>
                  
                </td>
            </tr>
        

              
            </table>



        </div>  
        <div id="step-2">   
            <h2 class="StepTitle">Registrar organizadores</h2>
            
            <table align="center" width="95%" style="margin-top:50px">
       
        <thead>
          <tr>
            <th width="150px">Dependencia</th>
            <th>Usuario</th>
            <th width="150px">Funcion</th>
            <th width="22">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
         <tr>
             <td ><select id="cbmdependencia" name="cbmdependencia[]" class="chosen-select" onChange="comboFuncion()" >
              <?php 
              llenar_combo2("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre",true)
              ?>
            </select></td>
            <td><input type="text" name="usuario[]" id="usuario" class="usuario"></td>
             <td ><select id="cbmfuncion" name="cbmfuncion[]" class="chosen-select">
              <?php
              llenar_combo2("SELECT * FROM Funcion",true);
              ?>
            </select></td>
           
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" align="right">
              <button type="button" class="clsAgregarFila" style="width:100%;padding-bottom:8px">Agregar una fila</button>
            
            </td>
          </tr>
        </tfoot>
      </table>





        </div>                     
        <div id="step-3">
             <h2 class="StepTitle">Programar agenda</h2> 


  <table align="center" width="95%" style="margin-top:50px">
       
        
        <tbody>
 
          <tr>
          <td>   

          <div colspan="3" style=" height:24px; text-align:center;padding:2px;margin-bottom:4px" class="ui-state-active">Agregar agenda</div>
         

          <div class="label"> Fecha <input type="date" class="clsAnchoTotal" name="txtfecha[]" id="txtfecha" style="width:50%;float:right"></div>
            
        

           <div class="label"> Hora inicio <select name="txthorainicia[]" id="txthorainicia" style="width:50%;float:right">
            <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?> </select> </div>
            
            <div class="label"> Hora termina <select  name="txthorafin[]" id="txthorafin" style="width:50%;float:right">
             <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?></select></div>
            
          <div class="label"> Exponente <input type="text"  name="txtexponente[]" id="txtexponente" style="width:50%;float:right" class="usuario"></div>
            

            <div class="label"> Tema <input type="text"  name="txttema[]" id="txttema" style="width:50%;float:right"></div>
            

          <div class="label"> Cupos <input type="number" placeholder=" 0  es tener usuarios ilimitados" class="numeros"  name="txtcupos[]" id="txtcupos" style="width:50%;float:right"></div>
            
           <div class="label"> Escenario <select style="width:50%;float:right" name="cbmescenario[]" id="cbmescenario">
              <?php
              llenar_combo2("SELECT id as codigo, nombre FROM escenario WHERE estado_id='1'",true);
              ?>
           </select>  </div>
            
           </td>
 
          </tr>

        </tbody>
        <tfoot>
          <tr>

            <td colspan="4" align="right">
               <button type="button" class="clsAgregarFila2" style="width:100%;padding-bottom:8px">Agregar una fila</button>
            
            </td>
          </tr>
        </tfoot>
      </table>  

        </div>
        <div id="step-4">
            <h2 class="StepTitle">Conclusiones</h2>   
         
             <table width="90%" style="margin:auto;margin-top:30px">
              
              
            
             <tr>
               
                <td class="tdd">
                <div style="border-radius:6px;box-shadow:0px 0px 8px red inset;height:20px;padding:5px;text-align:center">Ingrese conclusiones si hay, en caso contrario ingresar NO HAY</div>
       
                <textarea id="conclusiones" name="conclusiones" class="jqte-test" style="height:270px;width:100%;border-radius:4px"></textarea>
                  
                </td>
            </tr>
        
          

              
            </table>
             
        </div>
        </div>
<!-- End SmartWizard Content 1 -->

<!-- End SmartWizard Content 2 -->  
       
</form>

    
