<main class="page-row page-row-expanded"  style="background-color: #E9EAED;">
  <div class="container">
  	<br><br><br><br><br>
  	 <H1><?php if( isset($response) ){  if( $response<2 ){  echo strtoupper("hola, ".$name); }else{ echo $user." ".$msj; }  }else{ echo "INICIA SESIÓN";} ?>  </H1><br>
  	 
  	<form role='form' class='iniciar' id='iniciar' action='<?php echo site_url('Auth/login');?>' method='POST'>
	    <div class='form-group'>
	      <label for='user'>USUARIO: </label>
	      <input class='form-control' type='email' id='user' name='user'>
	    </div>
	    <div class='form-group'>
	      <label class='password'>CONTRASEÑA: </label>
	      <input class='form-control' type='password' id='password' name='password'>
	    </div>
	    <input class='btn btn-default' type='submit' name='Entrar'>
	    </form>
      <?php  if (isset($incorrecto)) { echo "<br><label> ".$incorrecto."</label><br>"; } ?> </label> 
  		
      <br><br><br><br>
      <label>REGISTRO</label><br>
  		<button class='btn btn-default'id="registro-usuario"> CIUDADANO</button>
  		<button class='btn btn-default'id="registro-trabajador"> TRABAJADOR</button>
  		<br><br>
  </div>

</main>