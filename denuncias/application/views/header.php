<!DOCTYPE html>
<html lang="en">
    <head>

    <link rel="shortcut icon" href="<?php echo base_url();?>img/favicon.ico" type="image/x-icon" />
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery-comments.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

   


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
            appId      : '1571236133186665', 
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
                                'id_rol': 2,
                                'id_cuenta': 2,
                                'name': details.name,
                                'user': details.email,
                                'password': 'a0'
                                };
                
              var url = "http://localhost/denuncias/index.php/usuarios";

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
                var url = "http://localhost/denuncias/index.php/auth/find/"+user;
                 
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
             alert("salir3");
            FB.logout(function(response){
                window.location = 'http://localhost/denuncias/index.php/Auth/logout';
            });
          
          });
        
        }

      }, { scope: permissions });

    });
 


 FB.getLoginStatus( function(response) {

    if (response.status === 'connected') {
        
        $("#salir").click(function(){
           alert("salir2");
          FB.logout(function(response){
              window.location = 'http://localhost/denuncias/Auth/logout';
          });
        
        });
    }else if (response.status === 'not_authorized') {
        
    }else {
             $("#salir").click(function(){
                alert("salir1");
                window.location = 'http://localhost/denuncias/index.php/Auth/logout';
              });
          }

  });

  $("#salir").click(function(){
                              window.location = 'http://localhost/denuncias/index.php/Auth/logout';
  });

/*
  FB.getLoginStatus( function(response) {

    if (response.status === 'connected') {
        console.log(response);
        mostrarDetallesFb();

        $("#salir").click(function(){

          FB.logout(function(response){
              window.location = 'http://incremento3.denunciaciudadana.esy.es/index.php/Auth/logout';
          });
        
        });
    }else if (response.status === 'not_authorized') {
        
    }else {
             $("#salir").click(function(){
                window.location = 'http://incremento3.denunciaciudadana.esy.es/index.php/Auth/logout';
              });
          }

  });*/

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
    
    var url = "http://localhost/denuncias/index.php/auth/loginFb";
    var id = id;
    var user = user;
    var name = name;

    var parametros = {
                        'id': id,
                        'user': user,
                        'name': name
                      };

  

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

    /* $.post('http://incremento3.denunciaciudadana.esy.es/index.php/auth/loginFb', parametros, function(data){
              console.log(data);
              var dataJson = eval(data);
              console.log(dataJson);
     });*/
  }
   
};
</script>
 


    <script type="text/javascript">
        $(document).ready(function(){
          
          $("#U-login").click(function(event){
            event.preventDefault();
            window.location = 'http://localhost/denuncias/index.php/sesion';
          });
          
           
          $("#registro-usuario").click(function(event){
            event.preventDefault();
            window.location = "<?php echo site_url('sesion/registrar_usuario');?>";
          });
          
          $("#registro-trabajador").click(function(event){
            event.preventDefault();
            window.location = "<?php echo site_url('sesion/registrar_trabajador');?>";
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





  <div class="navbar navbar-inverse navbar-fixed-top navbar-default" style="background-color: #3B5999;">
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
      <li id="reportar">
          <a href="<?php echo site_url('Reportes/reportar');?>">Denunciar</a>
      </li>
      <?php }?>

      <li id="dropdown-login" class="dropdown">
        <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Iniciar Sesión <b class="caret"></b> </a>
          <ul class="dropdown-menu">
          <li><a id="U-login" href="#">Usuario Registrado</a></li>
          <li class="divider"></li>
          <li><a  id="fb-login" href="#">Login con Facebook</a></li>
        </ul>
      </li>

    </ul>
  </div>
</div>