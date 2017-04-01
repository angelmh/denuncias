var p=0; var c=0;

// Load the SDK asynchronously
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

    function showDetails() {
			FB.api('/me', {fields: fields}, function(details) {
		      
		    $("#info").append(

        			  	$("<img/>", {
			              width: '25px',
			              height: '25px',
			              id: 'img-perfile'
			            }),

        			  	$("<span/>", {
			              id: 'name-perfile'
			            })

        		);

		      $("#img-perfile").attr('src','http://graph.facebook.com/'+details.id+'/picture?type=large');
		      $('#name-perfile').html(JSON.stringify(details.first_name, null, '\t'));

		      $('#G-login').remove();
		      $('#E-login').remove();
		     
		      console.log(details);

		
        var parametros = {

                          'user': details.email,
                          'estatus': 1,
                          'registrado_por': 2,
                          'name': details.name
                          
                        };

		var url = "http://localhost/api/index.php/usuarios/";

		$.ajax({
            type: 'POST',
            url: url,  
            data: parametros,
            success: function(data){
              						alert("Se ha registrado correctamente!");
            },
            error: function(objError,error){
            		alert("Existe un error");
            }
        });
		      /*
		      	email: "angelmh.am@gmail.com"
				first_name: "Angel"
				gender: "male"
				id: "912961415448947"
				last_name: "Montelongo"
				locale: "es_ES"
				name: "Angel Montelongo"
			*/

		      //$("#imagen2").attr('src',details.picture.data.url);
		      
		      /* Guardar ifo con .post o .ajax
		        var name = response.name;
		        $.post('ejemplo.php', {postname:name});
				$.ajax({
		                    type: "POST",
		                    url: "//api.apix.com.mx/v2/common/public/account/register",
		                    data: $.param(param_fields),
		                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		                }).success(function(response) {
		
		                }
		      */
	    });
	}


	$('#fb-login').click(function(){

	    FB.login(function(response) { 
	      if(response.authResponse) {
	          showDetails();
	          document.location.reload();		    
	      }
	    }, {scope: permissions});
	});


	



	FB.getLoginStatus( function(response) {
		if (response.status === 'connected') {
		 
		   	 console.log(response);
		     showDetails();
		     var perfil="<a id='perfil'>Perfil</a>"; 
		     var logout = "<a id='logout'>Cerrar Sesión</a>" ;
		     $("#fb-login").after(perfil); 
		     $('#fb-login').remove(); 
		     $('#E-login').remove();
		     $("#perfil").after(logout);	

		     $("#logout").click(function(){
		     	 
			     	 if (confirm("¿Está seguro?"))
		  			 {	FB.logout(function(response) {
				     	 	document.location.reload();
			             });
		  			}
		  			else
		  			{
		  			 return false;
		  			}
		     });

		     $("#perfil").click(function(){
		       		alert("Redireccionar a mi perfil");
		       });

		     $("#info-perfile").click(function(){
		       		alert("Redireccionar a mi perfil");
		       });
		  
		} else if (response.status === 'not_authorized') {
		    
		}else {
		      }
	});



  


  };

     




	
		 