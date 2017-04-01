<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Bienvenido | Denuncia Ciudadana </title>
		<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

	 

		<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css">

		<script src="<?php echo base_url();?>js/reportes.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>
   <script type="text/javascript">
      var p=0; var c=0;  
      var logoutFb ="<li><a href='#'>Link</a></li>"+
                    "<li>"+
                    "<a href='<?php echo site_url('Reportes/reportar');?>'>Denunciar</a></li>" +
                  "<li id='dropdown-logout' class='dropdown'>"+
                  "<a href='#'  id='U-logout' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='true'>"+
                    "<span class='caret'></span>"+
                  "</a>"+
                  "<ul class='collapsed dropdown-menu' id='menu'>"+
                    "<li><a href='#' id='perfil1'>Perfil</a></li>"+
                    "<li role='separator' class='divider'></li>"+
                    "<li><a href='#' id='salir' >Cerrar Sesión</a></li>"+
                  "</ul>"+
                "</li>";
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

       window.fbAsyncInit = function() {
          FB.init({
            appId      : '1252853788065069', 
            cookie     : true, 
            xfbml      : true,
            version    : 'v2.5'  
          });

      var permissions = [
              'email',
              'user_likes',
              'user_about_me'
              
              ].join(',');
      
      var fields = [
              'id',
              'name',
              'first_name',
              'middle_name',
              'last_name',
              'gender',
              'locale',
              'picture',
              'email',
             ].join(',');

   
    function registrarUsuarioFb()
    {
       
        FB.api('/me', {fields: fields}, function(details) {
              $('#userdata').html(JSON.stringify(details, null, '\t'));
              $('#fb-login').attr('style', 'display:none;');
              $("#imagen").attr('src','http://graph.facebook.com/'+details.id+'/picture?type=large');
              $("#imagen2").attr('src',details.picture.data.url);

              var parametros = {
                                'user': details.email,
                                'estatus': 1,
                                'registrado_por': 2,
                                'name': details.name
                                };
                
              var url = "http://www.denuncias.esy.es/index.php/usuarios";

              $.ajax({
                          type: 'POST',
                          url: url,  
                          data: parametros,
                          success: function(data){
                                        alert("Registrado");
                                        UsuarioRegistrado( data.id, data.user, data.name);
                                      
                                  
                          },
                          error: function(objError,error){
                              alert("Existe un error"+objError+error);
                           }
                      });

                
            });
    }

    function verificarUsuarioFb()
    {
    
        FB.api('/me', {fields: fields}, function(details) {
                $('#userdata').html(JSON.stringify(details, null, '\t'));
                $('#fb-login').attr('style', 'display:none;');
                $("#imagen").attr('src','http://graph.facebook.com/'+details.id+'/picture?type=large');
                $("#imagen2").attr('src',details.picture.data.url);

                var parametros = {
                                'user': details.email,
                                'estatus': 1,
                                'registrado_por': 2,
                                'name': details.name
                                };
                      
                var user =  encodeURIComponent(parametros.user);
                var url = "http://www.denuncias.esy.es/index.php/auth/find/"+user;
                 
                $.ajax({
                          type: 'GET',
                          url: url,  
                          success: function(data){
                                    console.log(data);
                                    
                                    if(data.find==true)
                                    {
                                      UsuarioRegistrado( data.data.id, data.data.user, data.data.name);
                                    }
                                    else
                                    {
                                      registrarUsuarioFb();
                                    }
                           
                                    
              
                          },
                          error: function(objError,error){
                              alert("Existe un error"+objError+error);
                           }
                      });
    
                
            });
    }


    $('#fb-login').click(function(){

      FB.login(function(response) { 

        if(response.authResponse) 
        {
        
          verificarUsuarioFb();
          
          $("#salir").click(function(){

            FB.logout(function(response){
                window.location = 'http://www.denunciaciudadana.esy.es/index.php/Auth/logout';
            });
          
          });
        
        }

      }, { scope: permissions });

    });
 


  


  FB.getLoginStatus( function(response) {

    if (response.status === 'connected') {
        console.log(response);
        mostrarDetallesFb();

        $("#salir").click(function(){

          FB.logout(function(response){
              window.location = 'http://www.denunciaciudadana.esy.es/index.php/Auth/logout';
          });
        
        });
    }else if (response.status === 'not_authorized') {
        
    }else {
             $("#salir").click(function(){
                window.location = 'http://www.denunciaciudadana.esy.es/index.php/Auth/logout';
              });
          }

  });

  function mostrarDetallesFb() 
  {
           FB.api('/me', {fields: fields}, function(details) {

                $('#userdata').html(JSON.stringify(details, null, '\t'));
                $('#fb-login').attr('style', 'display:none;');
                $("#imagen").attr('src','http://graph.facebook.com/'+details.id+'/picture?type=large');
                $("#imagen2").attr('src',details.picture.data.url);

                var parametros = {
                                  'user': details.email,
                                  'estatus': 1,
                                  'registrado_por': 2,
                                  'name': details.name
                                  };
                      
               
            });
  }

  function UsuarioRegistrado(id, user, name)
  {
    
    var url = "http://www.denunciaciudadana.esy.es/index.php/auth/loginFb";
    var id = id;
    var user = user;
    var name = name;

    var parametros = {
                        'id': id,
                        'user': user,
                        'name': name
                      };
    console.log(parametros);

     $.ajax({
            type: 'POST',
            url: url,  
            cache: false, 
            data: parametros,
            success: function(data){
              console.log(data);
              var dataJson = eval(data);
              console.log(dataJson);
              document.location.reload();  
            },
            error: function(objError,error){
                alert("Existe un error"+ objError+error);
             }
    });

    /* $.post('http://www.denunciaciudadana.esy.es/index.php/auth/loginFb', parametros, function(data){
              console.log(data);
              var dataJson = eval(data);
              console.log(dataJson);
     });*/
  }
   
};
</script>
 


    <script type="text/javascript">
        $(document).ready(function(){

          
    

          $("#U-login").click(function(){
      
            BootstrapDialog.show({
                    title: 'Iniciar Sesión',
                    
                    message: "<form role='form' class='iniciar' id='iniciar' action='<?php echo site_url('Auth/login');?>' method='POST'>"+
                            "<div class='form-group'>"+
                              "<label for='user'>Usuario: </label>"+
                              "<input class='form-control' type='email' id='user' name='user'>"+
                            "</div>"+
                            "<div class='form-group'>"+
                              "<label class='password'>Contraseña: </label>"+
                              "<input class='form-control' type='password' id='password' name='password'>"+
                            "</div>"+
                            "<input class='btn btn-default' type='submit' name='Entrar'>"+
                            "</form>",

                    buttons: [{
                                label: '¿No tienes Cuenta?',
                                action: function(dialog) {
                                    
                                    dialog.setTitle('Registrate');

                                    dialog.setMessage("<form role='form' action='<?php echo site_url('Registrar/registrarusuario');?>' method='POST' action='#'>"+
                                                      "<div class='form-group'>"+
                                                        "<label for='name'>Nombre: </label>"+
                                                        "<input class='form-control' type='text' id='nombre' name='nombre'>"+
                                                      "</div>"+
                                                       "<div class='form-group'>"+
                                                        "<label for='user'>Correo electrónico: </label>"+
                                                        "<input class='form-control' type='email' id='user' name='user'>"+
                                                     "</div>"+
                                                      "<div class='form-group'>"+
                                                        "<label for='password'>Contraseña: </label>"+
                                                        "<input class='form-control' type='password' id='password' name='password'>"+
                                                     "</div>"+
                                                     "<input class='btn btn-default' type='submit' name='Entrar'>"+
                                                     "</form>"
                                                     );
                                    
                                }
                              }, 
                              {
                                label: 'Inicia Sesión',
                                action: function(dialog) {
                                  var msj = "<form role='form' class='iniciar' id='iniciar' action='<?php echo site_url('Auth/login');?>' method='POST'>"+
                                                        "<div class='form-group'>"+
                                                          "<label for='user'>Usuario: </label>"+
                                                          "<input class='form-control' type='email' id='user' name='user'>"+
                                                        "</div>"+
                                                        "<div class='form-group'>"+
                                                          "<label class='password'>Contraseña: </label>"+
                                                          "<input class='form-control' type='password' id='password' name='password'>"+
                                                        "</div>"+
                                                        "<input class='btn btn-default' type='submit' name='Entrar'>"+
                                                      "</form>";
                                       dialog.setTitle('Iniciar Sesión');
                                      dialog.setMessage(msj);
                                      
                                }
                              }
                            ]
                });

             });
 
 

        });

    </script>
    </head>
<body>

<script type="text/javascript">
  $(document).ready(function(){
  <?php 
      if (!is_null($this->session->userdata('usuario')))
      {
  ?>      
      var session = "<?php echo $this->session->userdata('usuario');  ?>";
   

  $('#dropdown-login').remove();
  

  var logout =  "<li id='dropdown-logout' class='dropdown'>"+
                  "<a href='#'  id='U-logout' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='true'>"+
                     "<i class='fa fa-user'></i>"+
                   "<span class='caret'></span>"+
                  "</a>"+
                  "<ul class='collapsed dropdown-menu' id='menu'>"+
                    "<li><a href='#' id='perfil1'>Perfil</a></li>"+
                    "<li role='separator' class='divider'></li>"+
                    "<li><a id='salir' href='#'>Cerrar Sesión</a></li>"+
                  "</ul>"+
                "</li>";

  $("#reportar").after(logout); 

  
  <?php    
      }  
  ?>

  });
</script>





  <div class="navbar navbar-inverse navbar-fixed-top navbar-default">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-warning-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>">Denuncia Ciudadana</a>
    </div>
  <div class="navbar-collapse collapse navbar-warning-collapse">
   
    <ul class="nav navbar-nav navbar-right">
      <li id="comodin"></li>
      <?php if(!is_null( $this->session->userdata('usuario') ) ){?>
      <li><a href="#">Link</a></li>
      <li id="reportar">
          <a href="<?php echo site_url('Reportes/reportar');?>">Denunciar</a>
      </li>
      <?php }?>

      <li id="dropdown-login" class="dropdown">
        <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Iniciar Sesión <b class="caret"></b> </a>
          <ul class="dropdown-menu">
          <li><a id="U-login" href="#" >Usuario Registrado</a></li>
          <li class="divider"></li>
          <li><a  id="fb-login" href="#">Login con Facebook</a></li>
        </ul>
      </li>

    </ul>
  </div>
</div>