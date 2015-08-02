 <link type="text/css" rel="stylesheet" href="css/jquery.stepy.css" />

  <script type="text/javascript" src="js/jquery.stepy.js"></script>

  <div id="wrapper">
   

          <div class="demo">
            <form id="backLabel-nextLabel-demo">
              <fieldset title="Mensaje">
                <legend>Informacion del mensaje</legend>

                
                <p class="ocultar">
                  <label>Mensaje numero:</label>
                  <input type="text" name="id"  id="id" disabled="disabled"/>
                </p>
                <p>
                  <label>Correo:</label>
                  <input id="txtcorreo" name="txtcorreo" type="text"  disabled="disabled" />
                </p>

                <p>
                  <label>Asunto:</label>
                  <input id="txtasunto2" name="txtasunto2" type="text" disabled="disabled"  />
                </p>
                <p>
                  <label>Descripcion del mensaje:</label>
                  <textarea id="txtmensaje" name="txtmensaje"></textarea>
                </p>
              </fieldset>

              <fieldset title="Responder mensaje">
                <legend>Respuesta enviada al usuario</legend>

                <p>
                  <label for="name-2">Asunto:</label>
                  <input id="txtasunto2" name="txtasunto2" type="text" />
                </p>

                <p>
                  <label for="birthday-2">Enviado por:</label>
                   <input id="txtenviado_por" name="txtenviado_por" type="text" />
                </p>

                <p>
                  <label for="bio-2">Descripcion del mensaje</label>
                  <textarea id="txtrespuesta" name="txtrespuesta"></textarea>
                </p>
                 <input type="button" value="Enviar respuesta" style="width:150px;height:30px;float:right" />
              </fieldset>

             
            </form>
          </div>

         

       
  </div>

  <script type="text/javascript">
    $(function() {
     

      $('#backLabel-nextLabel-demo').stepy({
        backLabel: 'Atras',
        nextLabel: 'Responder'
      });

      
    });

    
  </script>

