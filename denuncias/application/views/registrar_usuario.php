<script type="text/javascript">
$(document).ready(function(){

 desactivar_formulario();
 
   $("#ife").keyup(function(){
                            if( ($("#ife").val().length == 18) )
                            {
                              $("#ife").css("border","3px solid #17995a");
                               $("#formulario").find("input").removeAttr("disabled");
                            }
                            else
                            {
                              $("#ife").css("border","3px solid #B13F3B");
                              desactivar_formulario();
                            }
                          });

   function desactivar_formulario()
      {
         $("#formulario").find("#nombre").attr("disabled", true);
         $("#formulario").find("#user").attr("disabled", true);
         $("#formulario").find("#password").attr("disabled", true);
         $("#formulario").find("#Entrar").attr("disabled", true);
      }

});



</script>

<main class="page-row page-row-expanded"  style="background-color: #E9EAED;">
  <div class="container">
  	<br><br><br><br><br>
    <h1>REGISTRO DE USUARIO CIUDADANO</h1>
  	<form role='form' name="formulario" id="formulario" action='<?php echo site_url('sesion/registrarusuario');?>' method='POST' action='#'>
        

        <div class="row">
        
          <div class="col-md-6"> 
              <div class="form-group">
                  <label>CLAVE DE ELECTOR: </label>
                  <input type="text" id="ife" name="ife" minlength="18" maxlength="18" class="form-control">
              </div>
          </div>
          <div class="col-md-6">


              <div class='form-group'>
                <label for='name'>NOMBRE: </label>
                <input class='form-control' type='text' id='nombre' name='nombre'>
              </div>

               <div class='form-group'>
                <label for='user'>CORREO ELECTRÓNICO: </label>
                <input class='form-control' type='email' id='user' name='user'>
             </div>
              <div class='form-group'>
                <label for='password'>CONTRASEÑA: </label>
                <input class='form-control' type='password' id='password' name='password'>
             </div>
             <input class='btn btn-default' type='submit' id="Entrar" name='Entrar'>
          </div>
        </div>

          
     </form>
     <br><br>
   </div>
</main>