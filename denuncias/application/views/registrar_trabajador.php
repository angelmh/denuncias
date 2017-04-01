<main class="page-row page-row-expanded"  style="background-color: #E9EAED;">
  <div class="container">
  	<br><br><br><br><br>
    <h1>REGISTRO DE USUARIO TRABAJADOR</h1>
  	<form role='form' action='<?php echo site_url('sesion/registrartrabajador');?>' method='POST' action='#'>
      
      <div class="form-group">
        <label for="categoria">CATEGORIA: </label>
        <select class="form-control" id="categoria" name="categoria">
          <?php foreach ($response as $key => $value) { ?>
          <option value="<?php echo $response[$key]['id']; ?>"> <?php  echo $response[$key]['categoria']; ?></option>
          <?php } ?>
        </select>
      </div>

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


     <input class='btn btn-default' type='submit' name='Entrar'>
     </form>
     <br><br>
   </div>
</main>