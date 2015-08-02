$(document).ready(function(){
	

	//evento que se dispara al hacer clic en el boton para agregar una nueva fila
	$(document).on('click','.clsAgregarFila',function(){
		//almacenamos en una variable todo el contenido de la nueva fila que deseamos
		//agregar. pueden incluirse id's, nombres y cualquier tag... sigue siendo html

		var strNueva_Fila='<tr>'+
			'<td><select id="cbmdependencia[]" name="cbmdependencia[]" class="cbmdependencia"></select></td>'+
			'<td><input type="text" name="usuario[]" id="usuario[]" class="usuario"></td>'+
			'<td><select id="cbmfuncion[]" name="cbmfuncion[]" class="cbmfuncion"></select></td>'+
			'<td align="right"><button class="clsEliminarFila" style="background-color:transparent"> <img src="img/close.png" width="20" height="17px"> </img> </button></td>'+
		'</tr>';
				
		/*obtenemos el padre del boton presionado (en este caso queremos la tabla, por eso
		utilizamos get(3)
			table -> padre 3
				tfoot -> padre 2
					tr -> padre 1
						td -> padre 0
		nosotros queremos utilizar el padre 3 para agregarle en la etiqueta
		tbody una nueva fila*/
		var objTabla=$(this).parents().get(3);
				
		//agregamos la nueva fila a la tabla
		$(objTabla).find('tbody').append(strNueva_Fila);
				
				comboFuncion();
				comboDependencia();
				auto();
		
		
		/*
	   			  $.ajax({
            url:"combox_eventos.php",
            type: "POST",
            data:"op="+5,
            success: function(opciones){
              

       var availableTags = [

opciones

        ];
        $( ".usuario" ).autocomplete({
            source: availableTags,
            delay:0
        });

              //alert(opciones);
            }
          })
*/
		//si el cuerpo la tabla esta oculto (al agregar una nueva fila) lo mostramos
		if(!$(objTabla).find('tbody').is(':visible')){
			//le hacemos clic al titulo de la tabla, para mostrar el contenido
			$(objTabla).find('caption').click();
		}
	});
	
	//cuando se haga clic en cualquier clase .clsEliminarFila se dispara el evento
	$(document).on('click','.clsEliminarFila',function(){
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
			if($(objCuerpo).find('tr').length==1){
				return;
				if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
					return;
				}
			}
					
		/*obtenemos el padre (tr) del td que contiene a nuestro boton de eliminar
		que quede claro: estamos obteniendo dos padres
					
		el asunto de los padres e hijos funciona exactamente como en la vida real
		es una jergarquia. imagine un arbol genealogico y tendra todo claro ;)
				
			tr	--> padre del td que contiene el boton
				td	--> hijo de tr y padre del boton
					boton --> hijo directo de td (y nieto de tr? si!)
		*/
		var objFila=$(this).parents().get(1);
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
			$(objFila).remove();
	});
	
	//evento que se produce al hacer clic en el boton que elimina una tabla completamente
	
			
});




$(document).ready(function(){
	

	//evento que se dispara al hacer clic en el boton para agregar una nueva fila
	$(document).on('click','.clsAgregarFila2',function(){
		//almacenamos en una variable todo el contenido de la nueva fila que deseamos
		//agregar. pueden incluirse id's, nombres y cualquier tag... sigue siendo html
	
		var strNueva_Fila='<tr>'+
          '<td>'+  
          '<div style="text-align:center;padding:5px;margin-bottom:10px" class="ui-state-active">Agregar Agenda<button class="clsEliminarFila2" style="float:right;width:32px;background-color:transparent"> <img src="img/close.png" width="20" height="17px" align="right" style="margin-top:-3px"> </img> </button></div>'+
          '<div class="label"> Fecha <input type="date" class="clsAnchoTotal" name="txtfecha[]" id="txtfecha" style="width:50%;float:right"></div>'+
          '<div class="label"> Hora inicio <select  name="txthorainicia[]" id="txthorainicia" style="width:50%;float:right" class="cbmhora"></select></div>'+
          '<div class="label"> Hora termina <select  name="txthorafin[]" id="txthorafin" style="width:50%;float:right" class="cbmhora"></select></div>'+
          '<div class="label"> Exponente <input type="text"  name="txtexponente[]" id="txtexponente"  class="usuario" style="width:50%;float:right"></div>'+
          '<div class="label"> Tema <input type="text"  name="txttema[]" id="txttema" style="width:50%;float:right"></div>'+
          '<div class="label"> Cupos <input type="number" placeholder=" 0  es tener usuarios ilimitados" class="numeros"  name="txtcupos[]" id="txtcupos" style="width:50%;float:right"></div>'+
          '<div class="label"> Escenario <select style="width:50%;float:right" name="cbmescenario[]" id="cbmescenario" class="cbmescenario"> </select>  </div>'+
         
          '</td>'+
          '</tr>';
				
	
	var objTabla=$(this).parents().get(3);
				
		//agregamos la nueva fila a la tabla
		$(objTabla).find('tbody').append(strNueva_Fila);
				
			auto();
			comboHoras();
			comboEscenario();



		//si el cuerpo la tabla esta oculto (al agregar una nueva fila) lo mostramos
		if(!$(objTabla).find('tbody').is(':visible')){
			//le hacemos clic al titulo de la tabla, para mostrar el contenido
	   $(objTabla).find('caption').click();

     /*  var availableTags = [

           opciones
        ];
        $( ".exponente" ).autocomplete({
            source: availableTags,
            delay:0
        });*/

              //alert(opciones);
            }
          });


		/*obtenemos el padre del boton presionado (en este caso queremos la tabla, por eso
		utilizamos get(3)
			table -> padre 3
				tfoot -> padre 2
					tr -> padre 1
						td -> padre 0
		nosotros queremos utilizar el padre 3 para agregarle en la etiqueta
		tbody una nueva fila*/
	//cuando se haga clic en cualquier clase .clsEliminarFila se dispara el evento
	$(document).on('click','.clsEliminarFila2',function(){
		/*obtener el cuerpo de la tabla; contamos cuantas filas (tr) tiene
		si queda solamente una fila le preguntamos al usuario si desea eliminarla*/
		var objCuerpo=$(this).parents().get(2);
			if($(objCuerpo).find('tr').length==1){
				return;
				if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
					return;
				}
			}
					
		/*obtenemos el padre (tr) del td que contiene a nuestro boton de eliminar
		que quede claro: estamos obteniendo dos padres
					
		el asunto de los padres e hijos funciona exactamente como en la vida real
		es una jergarquia. imagine un arbol genealogico y tendra todo claro ;)
				
			tr	--> padre del td que contiene el boton
				td	--> hijo de tr y padre del boton
					boton --> hijo directo de td (y nieto de tr? si!)
		*/
		var objFila=$(this).parents().get(1);
			/*eliminamos el tr que contiene los datos del contacto (se elimina todo el
			contenido (en este caso los td, los text y logicamente, el boton */
			$(objFila).remove();
	});
	

			
});


