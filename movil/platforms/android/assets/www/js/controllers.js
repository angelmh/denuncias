angular.module('starter.controllers', [])



.controller('LoginCtrl', function($scope, $http, $state, userService, LoginService){
  console.log("Entrando en login");
  
   $scope.data = {};

    $scope.login = function() {

        var usuario = $scope.data.username;
        var password = $scope.data.password;
        var params= {
                  'user': usuario,
                  'password': password
                 };

        var req = {
                    method: 'POST',
                    url: "http://www.denunciaciudadana.esy.es/index.php/auth/",
                    data: params
                  };

        
        // TIPO DE USUARIO
        //ciudadano, trabajador, administrador del sistema.
              
        $scope.trabajador = LoginService.LoginTrabajador(usuario,password).success(function(data){
                if (data.response>0)
                {
                    
                    console.log("ID : " + data.data.id);
                    console.log("NAME : " + data.data.name);
                    console.log("DPTO. : " + data.data.id_dpto);
                    userService.user.setProperty(usuario);
                    userService.id.setProperty(data.data.id);
                    userService.name.setProperty(data.data.name)
                    userService.departamento.setProperty(data.data.id_dpto)
                    
                    $state.go('usuariotrabajador.reportes');
                }
                else
                {
                  
                    $http(req).
                    success(function (data){
                          console.log("response: "+data.response);
                          if (data.response>0)
                          {
                            /*
                            console.log("data.id: "+data.data.id);
                            console.log("data.id_rol: "+data.data.id_rol);
                            console.log("data.id_cuenta: "+data.data.id_cuenta);
                            console.log("data.name: "+data.data.name);
                            console.log("data.user: "+data.data.user);
                            console.log("data.password: "+data.data.password);*/

                            $scope.data = {};
                            $scope.datos = [];
                            userService.user.setProperty(usuario);
                            userService.id.setProperty(data.data.id);
                            userService.name.setProperty(data.data.name);
                            
                            $scope.datos.user = userService.user.getProperty();
                            console.log("LoginCtrl: " + $scope.datos.user); 

                            $state.go('tab.denunciar');

                             
                              
                              
                          }
                          else
                          {
                            alert("Credenciales incorrectas");
                          }
                      }).
                      error(function(error){
                        alert("error");
                        console.log("usuario: "+usuario+" password: "+password);
                        console.log("error: "+error);
                       }); 
                }
        });

        
    }
})



.controller('DatosController', function($scope,$http,userService){
    console.log("Entrando en Datos");
    
    
    $scope.user = userService.user.getProperty();
    console.log("DatosCtrl user: " + $scope.user); 
    
    $scope.id = userService.id.getProperty();
    console.log("DatosCtrl id: " + $scope.id); 

    $scope.name = userService.name.getProperty();
    console.log("DatosCtrl user: " + $scope.name);    
})



.controller('HomeController', function($scope){
  console.log("Entrando en la home");
})


.controller('DenunciarController', function($scope, $http,$cordovaCamera,$cordovaFileTransfer,SrcImagenService,DireccionService,ImagenService){
    var map; var marker; 
    $scope.visibilidadcolonia = false; 
    $scope.visibilidadnumero = false; 
    $scope.visibilidadstep1 = false; 
    $scope.visibilidadstep2 = false;

   
    $scope.data = {};

    console.log("Not initialize");
    google.maps.event.addDomListener(window, 'load', initialize());

    // Incio Initialize
    function initialize() 
    {
      
        var mapOptions = {
          center: {lat: 31.692204334599186, lng: -106.42232177734377},
          zoom: 17,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          mapTypeControlOptions: {
            mapTypeIds: []
          },
          panControl: false,
          streetViewControl: false,
          zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
          }
        };
     
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
   
        //Inicio encontrarDireccion
        function encontrarDireccion(latitud,longitud)
        {
          var req = {
                      method: 'POST',
                      url: "http://maps.googleapis.com/maps/api/geocode/json?latlng="+latitud+","+longitud+"&sensor=true",
                      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    };
          $http(req).
          success(function (data){
              console.log(data);
              var direccion = data.results[0].formatted_address;
              $scope.direccion = direccion;
              console.log(direccion);
               $scope.htmldireccion ='<div id="htmldireccion">'+direccion+'</div>';
              console.log(data.results[0].address_components[0]);
              var address_components = data.results[0].address_components;
              console.log(address_components);
              var i;
              
              var country, postal_code, locality, sublocality, street_number, route;
              for (i = 0; i < address_components.length; ++i) {
                  var component = address_components[i];
                  if (!sublocality && component.types.indexOf("sublocality") > -1)
                      sublocality = component.long_name;
                  else if (!locality && component.types.indexOf("locality") > -1)
                      locality = component.long_name;
                  else if (!postal_code && component.types.indexOf("postal_code") > -1)
                      postal_code = component.long_name;
                  else if (!country && component.types.indexOf("country") > -1)
                      country = component.long_name;
                  else if (!street_number && component.types.indexOf("street_number") > -1)
                      street_number = component.long_name;
                  else if (!route && component.types.indexOf("route") > -1)
                      route = component.long_name;

              }
              console.log("country: "+country);
              console.log("route: "+ route);
              console.log("cp: "+postal_code);
              console.log("locality: "+locality);
              console.log("numero: "+street_number);
              console.log("colonia: "+sublocality);
              
              DireccionService.country.setProperty(country);
              DireccionService.route.setProperty(route);
              DireccionService.postal_code.setProperty(postal_code);
              DireccionService.locality.setProperty(locality);
              DireccionService.numero.setProperty(street_number);
              DireccionService.colonia.setProperty(sublocality);
              DireccionService.latitud.setProperty(latitud);
              DireccionService.longitud.setProperty(longitud);  
              DireccionService.descripcion_direccion_by_google.setProperty(direccion);  
    

              if( (typeof(sublocality) == "undefined") && (typeof(street_number) == "undefined")  ) 
              {
                console.log("falta colonia y numero");
                //Crear dos input colonia y uno para numero
                $scope.visibilidadcolonia = true;
                $scope.visibilidadnumero = true;

                $scope.visibilidadstep1 = false;
              }
              else if( typeof(sublocality) == "undefined")
              {
                console.log("falta colonia");
                //crear input colonia
                $scope.visibilidadnumero = false;
                $scope.visibilidadcolonia = true;
                
                $scope.visibilidadstep1 = false;
              }
              else if( typeof(street_number) == "undefined")
              {
                console.log("falta numero");
                //crear input numero
                $scope.visibilidadcolonia = false;
                $scope.visibilidadnumero = true;

                $scope.visibilidadstep1 = false;
              }
              else if( (typeof(street_number) != "undefined") || (typeof(sublocality) != "undefined") )
              {
                $scope.visibilidadstep1 = true;
                $scope.visibilidadcolonia = false;
                $scope.visibilidadnumero = false;
              }
              


          }).
          error(function(){

          }); 

        }//Fin encontrarDireccion
    
         



        function placeMarker(location) 
        {
          if ( marker ) {
            marker.setPosition(location);
          }
          else 
          {
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true
            });
          }
        }   
    
        google.maps.event.addListener(map,'click', function(event){
            placeMarker(event.latLng);
            encontrarDireccion( event.latLng.lat(), event.latLng.lng() ); 
            google.maps.event.addListener(marker,'dragend', function(event){
                var latitud = marker.getPosition().lat();
                var longitud = marker.getPosition().lng();
                placeMarker(event.latLng);
                encontrarDireccion(latitud,longitud);
            });
        });

        navigator.geolocation.getCurrentPosition(function(pos) {
            var latitud = pos.coords.latitude;
            var longitud = pos.coords.longitude;
            alert("lt: "+latitud+" longitud:"+longitud);
            
            map = new google.maps.Map( document.getElementById('map') ,{
                            center:{
                              lat: latitud,
                              lng: longitud
                            },
                            zoom: 17
                          });
            encontrarDireccion(latitud,longitud);

            placeMarker(  new google.maps.LatLng( latitud, longitud ) );

            google.maps.event.addListener(map,'click', function(event){
                      placeMarker(event.latLng);
                      encontrarDireccion( event.latLng.lat(), event.latLng.lng() ); 
            });                 

            google.maps.event.addListener(marker,'dragend', function(event){
              var latitud = marker.getPosition().lat();
              var longitud = marker.getPosition().lng();
              placeMarker(event.latLng);
              encontrarDireccion(latitud,longitud);
            });
        });


        $scope.map = map;

        $scope.validarInputNumero = function ()
        {
           
            var sizeNumero = $scope.data.numero;
            if ( sizeNumero.length >=2 ) 
            {
              $scope.visibilidadstep1 = true;
              DireccionService.numero.setProperty($scope.data.numero);
            }
           
        }
        
        $scope.validarInputColonia = function()
        {
          var sizeColonia = $scope.data.colonia;
           if(sizeColonia.length >=5)
            {
              $scope.visibilidadstep1 = true;
              DireccionService.colonia.setProperty($scope.data.colonia);
            }
        }
            
         $scope.imgURI = SrcImagenService.imagen.getProperty();
                  

      document.addEventListener("deviceready", function () {
              /*$scope.choosePhoto = function () {
                    alert("choosePhoto");
                        $scope.visibilidadstep2 = true;
                 
                    var options = {
                        quality: 85,
                        destinationType: Camera.DestinationType.FILE_URI,
                        sourceType: Camera.PictureSourceType.PHOTOLIBRARY,
                        targetWidth: 300,
                      targetHeight: 300,
                       allowEdit: true,
                       encodingType: Camera.EncodingType.JPEG,
                       popoverOptions: CameraPopoverOptions,
                       saveToPhotoAlbum: true
                    };

                    $cordovaCamera.getPicture(options).then(function (imageData) {
                        
                        SrcImagenService.imagen.setProperty(imageData);

                         $scope.imgURI = SrcImagenService.imagen.getProperty();
                        alert("imgURI: "+$scope.imgURI);
                    
                    }, function (err) {
                        // An error occured. Show a message to the user
                        alert("error"+err);
                    });
              }*/

              $scope.takePicture=function(){
                
                  $scope.visibilidadstep2 = true;
                
                
                  var options = {
                    quality: 85,
                    destinationType: Camera.DestinationType.FILE_URI,
                    sourceType: Camera.PictureSourceType.CAMERA,
                    allowEdit: true,
                    encodingType: Camera.EncodingType.JPEG,
                    //targetWidth: 300,
                    //targetHeight: 300,
                    popoverOptions: CameraPopoverOptions,
                    saveToPhotoAlbum: false,
                    correctOrientation:true
                  };

                $cordovaCamera.getPicture(options).then(function(imageData) {
                  var image = document.getElementById('myImage');
                  // image.src = "data:image/jpeg;base64," + imageData;
                  SrcImagenService.imagen.setProperty(imageData);
                  $scope.imgURI = SrcImagenService.imagen.getProperty();

                }, function(err) {
                  // error
                });
                
                
            };

      }, false);


    }
    //Fin Initialize 

})


.controller('DenunciarController2',function($scope, $http, $state, $cordovaCamera,$cordovaFileTransfer,SrcImagenService,DireccionService, userService, ImagenService){

  $scope.direccion = {};
  $scope.data = {};
  $scope.imgURI = SrcImagenService.imagen.getProperty();
  
  $http.get('http://www.denunciaciudadana.esy.es/index.php/reportes/categorias')
  .success(function(data){
    console.log(data.response);
    $scope.detalles =  data.response;
  }); 


  $scope.direccion.country = DireccionService.country.getProperty();  
  $scope.direccion.route = DireccionService.route.getProperty();  
  $scope.direccion.postal_code = DireccionService.postal_code.getProperty();  
  $scope.direccion.locality = DireccionService.locality.getProperty();  
  $scope.direccion.numero = DireccionService.numero.getProperty();  
  $scope.direccion.colonia = DireccionService.colonia.getProperty();  
  $scope.direccion.latitud = DireccionService.latitud.getProperty();  
  $scope.direccion.longitud = DireccionService.longitud.getProperty();  
  $scope.direccion.descripcion_direccion_by_google = DireccionService.descripcion_direccion_by_google.getProperty();  
    

  $scope.user = userService.id.getProperty();  
  


  $scope.subirReporte=function(){
    var url='http://www.denunciaciudadana.esy.es/index.php/reportes/imagen'; //local server//
          var targetSimpan = SrcImagenService.imagen.getProperty();
          var filename     = targetSimpan.split("/").pop();
          var formatFile   = targetSimpan.split(".").pop();

          var options={
            fileKey:'file',
            fileName:filename,
            chunkedMode:false,
            mimeType:'image/'+formatFile,
          };
         
          
          $cordovaFileTransfer.upload(url,targetSimpan,options).then(function(result) 
          {
             
            
              var data = result.response;
              var img = JSON.parse(data);
              if (img.response>=1) 
              {
                  ImagenService.imagen.setProperty( img.response );
                  $scope.imagen = ImagenService.imagen.getProperty();
                  
                  var params={
                        'usuario': $scope.user,
                        'categoria': $scope.data.categoria,
                        'imagen': $scope.imagen,
                        'descripcion': $scope.data.descripcion,
                        'latitud': $scope.direccion.latitud,
                        'longitud': $scope.direccion.longitud,
                        'direccion': $scope.direccion.descripcion_direccion_by_google,
                        'cp': 'undefined',
                        'calle_avenida': $scope.direccion.route,
                        'numero': $scope.direccion.numero,
                        'colonia': $scope.direccion.colonia
                      }; 

                  var req = {
                              method: 'POST',
                              url: "http://www.denunciaciudadana.esy.es/index.php/reportes/reporte",
                              data: params
                            };

                  $http(req).
                  success(function (data){

                    alert("Reporte Subido Correctamente.");
               
                    
                    $state.go('tab.comunidad');


                  }).
                  error(function(error){
                      alert("error al subir reporte"+JSON.stringify(error));
                   }); 
              }
              else
              {
                alert("No se ha podido enviar su información");
              }   

          }, function (err) {
              
              console.log("ERROR: " + JSON.stringify(err));
              alert(JSON.stringify(err));

          }, function(progress){
              alert("...");
          });
          
         

  } 

})


.controller('ComunidadController', function( $scope, $http, $state){

  //$http.get('js/data.json')
  $http.get('http://www.denunciaciudadana.esy.es/index.php/reportes')
  .success(function(data){
    console.log(data.response);
    $scope.detalles =  data.response;
  }); 

})

.controller('CerrarController', function( $scope ){
    $scope.close = function()
    {
    ionic.Platform.exitApp();
    }
})

.controller('ReporteController', function( $scope, $http, $state,userService){
    
    $scope.visibilidadApoyo = false;
    $scope.visibilidadCancelar = false;
   // console.log( "id:"+$state.params.id);
   var var1 = $state.params.id;
   console.log("var1: "+var1);

    $http.get('http://www.denunciaciudadana.esy.es/index.php/reportes/find/'+var1)
    .success(function(data){
       //$scope. =  data.response;
       console.log("name: "+data.response.name);
       $scope.detalles =  data.response;
    });

    total_reporte();
    

    $scope.user = userService.id.getProperty();  
    
    $scope.voto = '';
    $http.get("http://www.denunciaciudadana.esy.es/index.php/votos/reporte/"+var1+"/"+$scope.user)
    .success(function(data){
      console.log("Data.is_true: "+data.is_true);
          
          
          if (data.is_true==true)
          {
            
            var voto = data.voto.id;
            $scope.voto = voto;
            if (data.voto.cantidad==1) 
              {
                // poder cancelar en el mismo registro
                $scope.visibilidadCancelar = true;
              }
              else if(data.voto.cantidad==0)
              {
                  //poder votar en el mismo registro
                 $scope.visibilidadApoyo = true;
              }
          }
          else
          {
            //Poder votar en registro nuevo
            $scope.visibilidadApoyo = true;
          }
     });

      $scope.apoyar =function()
      {
         var params = {
                        'reporte': var1,
                        'usuario': $scope.user
                        };
       
                      var req = {
                                  method: 'POST',
                                  url: "http://www.denunciaciudadana.esy.es/index.php/reportes/votar",
                                  data: params
                                };

                      $http(req).
                      success(function (data){

                        if (data.response!=0)
                        {
                          
                          var voto = data.response;
                          $scope.voto = voto;
                          esconder_btn_apoyo();
                          total_reporte();
                        }

                      }).
                      error(function(error){
                          alert("error: "+JSON.stringify(error));
                       }); 
      };

      $scope.cancelar =function()
      {
            var params = {
                      'voto': $scope.voto
                      };
            var req = {
                    method: 'PUT',
                    url: "http://www.denunciaciudadana.esy.es/index.php/reportes/cancelarvoto",
                    data: params
                  };

            $http(req).
            success(function (data){
              if (data.response!=0)
              {
                  console.log(data.response);
                  esconder_btn_cancelar();
                  total_reporte();
              }


            }).
            error(function(error){
                alert("error: "+JSON.stringify(error));
             });

      };

      function esconder_btn_apoyo()
      {
        $scope.visibilidadApoyo = false;
        $scope.visibilidadCancelar = true;
      }
      
      function esconder_btn_cancelar()
      {
        $scope.visibilidadApoyo = true;
        $scope.visibilidadCancelar = false;
      }

      function total_reporte()
      {
          $http.get('http://www.denunciaciudadana.esy.es/index.php/votos/cantidad/'+var1)
          .success(function(data){
            if (data.cantidad.total == null) 
            {
             data.cantidad.total = 0; 
            }
              console.log("total votos : "+data.cantidad.total);
              $scope.data =  data.cantidad;
              console.log("data: "+data.cantidad.total);
           });
      }

})





/*----------USUARIO TRABAJADOR----------------------------------*/

.controller('TrabajadorReportesController', function($scope){
  console.log("TrabajadorReportesController");
})

/*.controller('TrabajadorComunidadController', function( $scope, $http, userService){

  $scope.departamento = userService.departamento.getProperty();
  console.log("departamento: "+$scope.departamento);

  $http.get('http://www.denunciaciudadana.esy.es/index.php/reportes/reportescategoria/'+$scope.departamento)
  .success(function(data){
    console.log(data.response);
    $scope.detalles =  data.response;
  }); 

})*/

.controller('TrabajadorReporteController', function( $scope, $http, $state, userService,EstatusService){
  $scope.data={};
  // console.log( "id:"+$state.params.id);
  var var1 = $state.params.id;
  $scope.user = userService.id.getProperty();  
  console.log("var1: "+var1);
  
  cargarInformacion();
    
    $scope.cambiarEstatus= function()
    {
      

      var params= {
                    'id': var1,
                    'id_estatus': $scope.data.estatus,
                    'id_user': $scope.user
                  }; 

                  var req = {
                              method: 'PUT',
                              url: "http://www.denunciaciudadana.esy.es/index.php/reportes/modificarestatus",
                              data: params
                            };

                  $http(req).
                  success(function (data){
                    if (data.response>0) 
                    {
                      EstatusService.estatus.setProperty(true);
                      cargarInformacion();
                    }
                  }).
                  error(function(error){
                      alert("error: "+JSON.stringify(error));
                   }); 
    }

    function cargarInformacion()
    {
      $http.get('http://www.denunciaciudadana.esy.es/index.php/reportes/find/'+var1)
    .success(function(data){
       //$scope. =  data.response;
       console.log("name: "+data.response.name);
       $scope.detalles =  data.response;
    });

    $http.get('http://www.denunciaciudadana.esy.es/index.php/votos/cantidad/'+var1)
    .success(function(data){
      //$scope. =  data.response;
      if (data.cantidad.total == null) 
      {
       data.cantidad.total = 0; 
      }
        console.log("total votos : "+data.cantidad.total);
        $scope.data =  data.cantidad;
        console.log("data: "+data.cantidad.total);
    });

    }

})

.controller('TrabajadorDatosController', function($scope,userService){
  console.log("Entrando en Datos trabajador");

  $scope.user = userService.user.getProperty();
  console.log("DatosCtrl user: " + $scope.user); 
    
  $scope.id = userService.id.getProperty();
  console.log("DatosCtrl id: " + $scope.id); 

  $scope.name = userService.name.getProperty();
  console.log("DatosCtrl name: " + $scope.name); 

  $scope.departamento = userService.departamento.getProperty();
  console.log("DatosCtrl departamento: " + $scope.departamento); 
    
})

.controller('TrabajadorVotacionController', function( $scope, $http, userService){
  $scope.departamento = userService.departamento.getProperty();
  console.log("departamento: "+$scope.departamento);

  $http.get('http://www.denunciaciudadana.esy.es/index.php/votos/votoscategoria/'+$scope.departamento)
  .success(function(data){
    console.log(data.response);
    $scope.detalles =  data.response;
  }); 

})

.controller('TrabajadorRecientesController', function( $scope, $http, userService){
  $scope.departamento = userService.departamento.getProperty();
  console.log("departamento: "+$scope.departamento);

  $http.get('http://www.denunciaciudadana.esy.es/index.php/reportes/reportescategoriarecientes/'+$scope.departamento)
    .success(function(data){
      console.log(data.response);
      $scope.detalles =  data.response;
    });
})
