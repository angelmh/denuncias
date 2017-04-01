 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg3HyplYJwxn8BHKTyZW08g06Ve5MVMpo&libraries=places">
    </script>
<script type="text/javascript">
var map; var marker;
$(document).ready(function(){

      $.ajax({
              type: 'GET',
              url: "http://localhost/service/index.php/reportes/subcategorias/",  
              success: function(data){
                
                 
                for (var i =0; i<data.response.length; i++) 
                {
                 
                  
                    $('#subcategorias').append(

                      $('<option>', {
                          value: data.response[i].id,
                          text: data.response[i].subcategoria
                      })

                      );
                   
                }

               },
              error: function(objError,error){
                      console.log("parametros: "+parametros);
                      console.log(error);
                   
              } 
          });


    $("#divcategoria").hide();
    //ocultar pasos
    $("#paso-2").hide(); 
    $("#paso-3").hide();
    $("#paso-4").hide();
    
    if (navigator.geolocation) 
    {
         if(isMobileBrowser())
         {

             /* $('#map').remove();
              navigator.geolocation.watchPosition(mostrar_coordenadas, mostrar_errores, { 
                  maximumAge: 1000,   // 1 segundo
                  timeout: 300000,    // 5 minutos
                  enableHighAccuracy: true
              }
              );*/
            
            $('#lbl1').css('font-size', '32px');
            $('#instruccion1').css('padding-left', '4%');
            $('#o').css('padding-left', '47%');
            $('#mapsearch').css('width', '100%');
            
            alert("UTILIZA LA APPLICACIÓN MÓVIL");
         }
         else
         {
            navigator.geolocation.getCurrentPosition( 
                function (position)
                {

                    var latitud = position.coords.latitude;
                    var longitud = position.coords.longitude;
                    
                    map = new google.maps.Map( document.getElementById('map') ,{
                      center:{
                        lat: latitud,
                        lng: longitud
                      },
                      zoom: 15
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

                }, function(){ }

              );
          }

    }
    else
    {
      alert("SU NAVEGADOR NO SOPORTA LA LOCALIZACIÓN");
    }

  
  /*Si no permite la localización*/
    var latitudDefault = 31.692204334599186; var longitudDefault = -106.42232177734377;

    map = new google.maps.Map( document.getElementById('map') ,{
          center:{
            lat: latitudDefault,
            lng: longitudDefault
          },
          zoom: 15
    });


      
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


      var searchBox = new google.maps.places.SearchBox( document.getElementById('mapsearch') );

      //place change event on search box
      google.maps.event.addListener( searchBox, 'places_changed', function(event){
        //console.log( searchBox.getPlaces() );
        var  places = searchBox.getPlaces();
       
        //bound
        var bounds = new google.maps.LatLngBounds();
        var i, place;

        for (i = 0; place=places[i]; i++) 
        {
          console.log( place.geometry.location );  
          bounds.extend( place.geometry.location );
          
          //set marker position new..
          //marker.setPosition( place.geometry.location );
          placeMarker(  new google.maps.LatLng( place.geometry.location.lat() , place.geometry.location.lng() ) );
          encontrarDireccion( place.geometry.location.lat()  , place.geometry.location.lng() )
         
        }

        map.fitBounds(bounds); //fit to the bound
        map.setZoom[15];  //set Zoom
        
      });

      google.maps.event.addListenerOnce(map, 'zoom_changed', function(){
        var oldZoom = map.getZoom();
        console.log("oldzoom"+oldZoom);
        map.setZoom(15);
      });

  
    $(".messages").hide();
    var fileExtension = "";

    //función que observa los cambios del campo file y obtiene información
    $("input[name='file']").change(function() {
        var formData = new FormData( $("#form-archivo")[0] ); 
        var file = $("input[name='file']")[0].files[0];
        var fileName = file.name;
        fileExtension = fileName.substring( fileName.lastIndexOf('.') + 1);
        var fileSize = file.size;
        var fileType = file.type;
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
        var url = "http://localhost/service/index.php/reportes/imagen";
        var message  = ""; 
          
          $.ajax({
              type: 'POST',
              url: url,  
              data: formData,
              contentType: false,
              processData: false,          
              beforeSend: function(){
                  message = $("<span class='before'>Subiendo el imagen, por favor espere...</span>");
                  showMessage(message);        
              },
              success: function(data){
                  
                  var imagen = data.response;
                  
                  if (imagen>=1)
                  {
                    var inputhide = "<input type='hidden' id='inputhide' value='"+imagen+"'>";
                    $('#categoria').after(inputhide);
                    message = $("<span class='success'>La imagen se ha subido correctamente.</span>");
                    showMessage(message);

                    $("#paso-4").show();//Mostrar paso 3
                    subirReporte();
                  }
              
              },
              error: function(objError,error){
                      console.log(error);
                      message = $("<span class='error'>Ha ocurrido un error.</span>");
                      showMessage(message);
              } 
          });


    
    });

    function showMessage(message){
        $(".messages").html("").show();
        $(".messages").html(message);
    }
    
    function isImage(extension)
    {
        switch(extension.toLowerCase()) 
        {
            case 'jpg': case 'gif': case 'png': case 'jpeg':
                return true;
            break;
            default:
                return false;
            break;
        }
    }

    
   
    $("#subcategorias").on('change',function(event){
        var subcategoria = $(this).val();
       
        $.ajax({
              type: 'GET',
              url: "http://localhost/service/index.php/reportes/categoria_sub/"+subcategoria,  
              success: function(data){
                  $('#categoria option[value="'+data.response[0].id_categoria+'"]').prop('selected', 'selected').change();
                  var input = "<input type='hidden' id='subcategoria' value='"+subcategoria+"'>";
                  $('#paso-2').after(input);
                  $("#paso-3").show();
                  $("#divcategoria").show();
               },
              error: function(objError,error){
                      console.log("parametros: "+parametros);
                      console.log(error);
              } 
          });

        

    });

     
 function mostrar_errores(error) 
 {
    switch (error.code) {
      case error.PERMISSION_DENIED:
        alert('Permiso denegado');
        alert('Se necesita GPS');
        window.location = 'http://localhost/denuncias/';
        break;
      case error.POSITION_UNAVAILABLE:
        alert('Posición no disponible');
        break;
      case error.TIMEOUT:
        alert('Tiempo de espera agotado');
        break;
      default:
        alert('Error desconocido de Geolocalizacion:' + error.code);
    }
  }

  function isMobileBrowser()
  {    
      if(typeof window.orientation !== 'undefined'){
          return true;
      }
      else {
          return false;
      }
  }  
  
  function encontrarDireccion(latitud,longitud)
  {
      $.ajax({
          type: 'POST',
          url: "http://maps.googleapis.com/maps/api/geocode/json?latlng="+latitud+","+longitud+"&sensor=true",  
          beforeSend: function(){
          },
          success: function(data){
                      
                  if (data.status=="OK") 
                  {

                      var direccion = data.results[0].formatted_address;
                      $("#address").html('<div id="address"><label>Ubicación del reporte: </label> '+direccion+'</div>'+
                            '<input type="hidden" id="direccion" value="'+direccion+'">'+
                            '<input type="hidden" id="latitud" value="'+latitud+'">'+
                            '<input type="hidden" id="longitud" value="'+longitud+'">');
                    
                      console.log(data.results[0].address_components[0]);
                      var address_components = data.results[0].address_components;
                      var components={};
                      jQuery.each(address_components, function(k,v1) 
                      {
                        jQuery.each(v1.types, function(k2, v2){
                                                components[v2]=v1.long_name
                                              }
                                    );
                      })
                      console.log(components);
                      
                      
                                        
                      if( (typeof(components.street_number) != "undefined") && ( typeof(components.sublocality_level_1) != "undefined") ) 
                      {
                          
                          if($("#numero-ubicacion").length || $("#colonia-ubicacion").length)
                          {
                              $("#msj-ubicacion").remove();
                              $("#numero-ubicacion").remove();
                              $("#colonia-ubicacion").remove();
                              $(".br-ubicacion").remove();
                          }
                          $("#paso-2").show(); //Mostrar paso 2
                          var cp = components.postal_code;
                          var calle_avenida= components.route;
                          var numero = components.street_number;
                          var colonia = components.sublocality_level_1;
                          var inputs = "<input type='hidden' id='cp' value='"+cp+"'>"+
                                        "<input type='hidden' id='calle-avenida' value='"+calle_avenida+"'>"+
                                        "<input type='hidden' id='numero' value='"+numero+"'>"+
                                        "<input type='hidden' id='colonia' value='"+colonia+"'>";
                          $('#address-hide').after(inputs);

                      }
                      else if( (typeof(components.street_number) == "undefined") && ( typeof(components.sublocality_level_1) == "undefined")  ) 
                      {
                          $("#paso-2").hide();
                          if($("#numero-ubicacion").length || $("#colonia-ubicacion").length)
                          {
                              $("#msj-ubicacion").remove();
                              $("#numero-ubicacion").remove();
                              $("#colonia-ubicacion").remove();
                              $(".br-ubicacion").remove();
                          }

                          if ( $("#numero-ubicacion").length )
                          {

                          }
                          else
                          {
                              $("#address-hide").append(
                                  $("<label/>", {
                                    id: 'msj-ubicacion'
                                  }),
                                  $("<br>",{
                                      class: 'br-ubicacion'
                                  }),
                                  $("<input/>", {
                                    id: 'numero-ubicacion',
                                    minlength: '1',
                                    class: 'form-control ttminput',
                                    placeholder: 'Ingrese numero de referencia del reporte'
                                  }),
                                  $("<br>",{
                                      class: 'br-ubicacion'
                                  }),
                                  $("<input/>", {
                                    id: 'colonia-ubicacion',
                                    minlength:'5',
                                    class: 'form-control ttminput',
                                    placeholder: 'Ingrese colonia de referencia del reporte'
                                  })
                              );
                              $('#msj-ubicacion').html('En esta ubicación el mapa de Google no esta actualizado;'+
                                                    ' no tenemos su numero ni colonia');  
                              $('#numero-ubicacion').css('width', '29%');
                              $('#colonia-ubicacion').css('width', '29%');

                              //Campo colonia-ubicacion
                              $("#colonia-ubicacion").keyup(function(){
                                if( ($("#colonia-ubicacion").val().length >= 3) && ($("#colonia-ubicacion").val().length <= 40) )
                                {
                                   $("#colonia-ubicacion").css("border","3px solid #17995a");
                                    var cp = components.postal_code;
                                    var calle_avenida= components.route;
                                    var numero = $("#numero-ubicacion").val();  
                                    var colonia = $("#colonia-ubicacion").val();  
                                    var inputs = "<input type='hidden' id='cp' value='"+cp+"'>"+
                                                  "<input type='hidden' id='calle-avenida' value='"+calle_avenida+"'>"+
                                                  "<input type='hidden' id='numero' value='"+numero+"'>"+
                                                  "<input type='hidden' id='colonia' value='"+colonia+"'>";
                                    $('#address-hide').after(inputs);
                                   $("#paso-2").show(); //Mostrar paso 2
                                }
                                else
                                {
                                  $("#colonia-ubicacion").css("border","3px solid #B13F3B");
                                }
                              });

                            //Campo numero-ubicacion
                              $("#numero-ubicacion").keyup(function(){
                                if( ($("#numero-ubicacion").val().length >=1) )
                                {
                                  $("#numero-ubicacion").css("border","3px solid #17995a");
                                 
                                }
                                else
                                {
                                  $("#numero-ubicacion").css("border","3px solid #B13F3B");
                                }
                               
                              });

                               //Validar campo numero-ubicacion
                              $("#numero-ubicacion").keypress(function (event) {
                                          return isNumber(event, this)
                              });


                             
                          } 
                      }
                      else if(  typeof(components.sublocality_level_1) == "undefined" )
                      {
                          $("#paso-2").hide(); 
                          if($("#numero-ubicacion").length || $("#colonia-ubicacion").length)
                          {
                              $("#msj-ubicacion").remove();
                              $("#numero-ubicacion").remove();
                              $("#colonia-ubicacion").remove();
                              $(".br-ubicacion").remove();
                          }
                          //console.log( "No existe Colonia" );
                         
                          if ( $("#colonia-ubicacion").length ) {
                          }
                          else
                          {
                              $("#address-hide").append(

                                  $("<label/>", {
                                    id: 'msj-ubicacion'
                                  }),
                                  $("<br>",{
                                      class: 'br-ubicacion'
                                  }),
                                  $("<input/>", {
                                    id: 'colonia-ubicacion',
                                    class: 'form-control ttminput',
                                    minlength:'5',
                                    placeholder: 'Ingrese colonia de referencia del reporte'
                                  })
                              );
                              $('#msj-ubicacion').html('En esta ubicación el mapa de Google no esta actualizado;'+
                                                    ' no tenemos su colonia');
                              $('#colonia-ubicacion').css('width', '29%');
                            
                                //Campo colonia-ubicacion
                                $("#colonia-ubicacion").keyup(function(){
                                  if( ($("#colonia-ubicacion").val().length >= 3) && ($("#colonia-ubicacion").val().length <= 40) )
                                  {
                                    $("#colonia-ubicacion").css("border","3px solid #17995a");
                                    var pais = components.political;
                                    var estado = components.administrative_area_level_1;
                                    var ciudad = components.locality;
                                    var cp = components.postal_code;
                                    var calle_avenida= components.route;
                                    var numero = components.street_number;
                                    var colonia = $("#colonia-ubicacion").val();  
                                    var inputs = "<input type='hidden' id='pais' value='"+pais+"'>"+
                                                  "<input type='hidden' id='estado' value='"+estado+"'>"+
                                                  "<input type='hidden' id='ciudad' value='"+ciudad+"'>"+
                                                  "<input type='hidden' id='cp' value='"+cp+"'>"+
                                                  "<input type='hidden' id='calle-avenida' value='"+calle_avenida+"'>"+
                                                  "<input type='hidden' id='numero' value='"+numero+"'>"+
                                                  "<input type='hidden' id='colonia' value='"+colonia+"'>";
                                    $('#address-hide').after(inputs);
                                     $("#paso-2").show(); //Mostrar paso 2
                                  }
                                  else
                                  {
                                    $("#colonia-ubicacion").css("border","3px solid #B13F3B");
                                  }
                                });


                              

                            }

                      }
                  }
                  else
                  {
                    alert("API de Google No disponible, intentelo mas tarde");
                    window.location = 'http://localhost/denuncias/';  
                  }

          },
          error: function(objError,error){
          
          } 
      });
  }


function isNumber(evt, element) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  /*Para datos Numeric == (charCode != 45 || $(element).val().indexOf('-') != -1) && (charCode != 46 || $(element).val().indexOf('.') != -1) &&*/      
  if( (charCode < 48 || charCode > 57) || (charCode == 8) )
   return false;
   return true;  
}  

  function subirReporte()
  {

    
      $('#btn').click( function(event){
        event.preventDefault();
        
        $("#btn").attr("disabled",true); //desactivar boton

        var categoria     = $("#categoria"). val();
        var descripcion   = $("#descripcion").val();  
        var imagen        = $("#inputhide").val();  
        var latitud       = $("#latitud").val();  
        var longitud      = $("#longitud").val();  
        var direccion     = $("#direccion").val();  
        var usuario       = "<?php echo $this->session->userdata('usuario');  ?>";
        var cp            = $("#cp").val();
        var calle_avenida = $("#calle-avenida").val();
        var numero        = $("#numero").val();
        var colonia       = $("#colonia").val();
        var subcategoria  = $("#subcategoria").val();
        console.log("usuario"+usuario);
        console.log("subcategoria"+subcategoria);
        console.log("categoria"+categoria);
        console.log("descripcion"+descripcion);
        console.log("imagen"+imagen);
        console.log("latitud: "+latitud+" longitud: "+longitud+" direccion: "+direccion);
        console.log("cp"+cp);
        console.log("calle_avenida"+calle_avenida);
        console.log("numero"+numero);
        console.log("colonia"+colonia);
                 
        
        

        var parametros = {
                        'usuario': usuario,
                        'categoria': categoria,
                        'subcategoria': subcategoria,
                        'imagen': imagen,
                        'descripcion':descripcion,
                        'latitud': latitud,
                        'longitud': longitud,
                        'direccion': direccion,
                        'cp': cp,
                        'calle_avenida': calle_avenida,
                        'numero': numero,
                        'colonia': colonia
                      };

      $.ajax({
              type: 'POST',
              url: "http://localhost/service/index.php/reportes/reporte",  
              data: parametros,
              beforeSend: function(){
                
              },
              success: function(data){
                  console.log(data);
                  alert("Reporte subido correctamente");
                  window.location = 'http://localhost/denuncias/';                  

              },
              error: function(objError,error){
                      console.log("parametros: "+parametros);
                      console.log(error);
                   
              } 
          });
          $("#btn").attr("disabled",true); 
          return false;


    });//fin event click

    

  }//fin subirReporte
   


});
</script>

<style type="text/css">
        #map{
          display: block;
          width: 75%;
          height: 250px;
          margin: 4em auto;
          -moz-box-shadow: 0px 5px 20px #ccc;
          -webkit-box-shadow: 0px 5px 20px #ccc;
          box-shadow: 0px 5px 20px #ccc;
          }
</style>

<main class="page-row page-row-expanded"  style="background-color: #E9EAED;">
  <div class="container">
      <br><br><br>
      <div id="paso-1">
          <label id="lbl1" style="font-size:30px; padding-left: 18%;">PASO 1) SELECCIONÉ EL LUGAR DEL REPORTE</label><br>
          <div id="instruccion1" style="padding-left: 31%;"> 
              <p> MUÉVASE POR EL MAPA Y SELECCIONÉ LA UBICACIÓN </p>  <br>
              <p id="o"style="padding-left: 23%;"> Ó </p>  <br>
              <input type="text" id="mapsearch" size="40" class="form-control" placeholder="ENCUENTRA LA DIRECCIÓN DEL REPORTE" style="width: 50%;">
          </div>
          <div id="map"></div>
          <div id="address" style="padding-left: 13%;"><label>UBICACIÓN DEL REPORTE: </label></div>
          <div id="address-hide" style="padding-left: 13%;"></div>
      </div>
  
      <br> 
         <br> 
          <div id="paso-2">
                <label style="font-size:30px">PASO 2) SELECCIONÉ EL PROBLEMA:</label>
                <div class="form-group">
                    <select  class="selectpicker" data-live-search="true" title=" " id="subcategorias" name="subcategorias" data-size="5" data-width="100%">
                      <option data-hidden="true" value="" id="subcategoria-option" name="subcategoria-option"></option>
                    </select>
              
                  <div id="divcategoria">
                      <select class="selectpicker"  data-live-search="false" title=" " id="categoria" name="categoria" data-width="100%" disabled="disabled">
                         <option data-hidden="true" value="" id="categoria-option" name="categoria-option"></option>
                        <?php foreach ($response as $key => $value) { ?>
                        <option value="<?php echo $response[$key]['id']; ?>"> <?php  echo $response[$key]['categoria']; ?></option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
          </div>

          


          <br>
             <div id="paso-3">
              <label style="font-size:30px"> PASO 3)DESCRIBA EL REPORTE </label><br>
              <div class="form-group">
                  <label for="descripcion">DESCRIPCIÓN: </label>
                  <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Opcional"></textarea>
              </div>
              
              <form id="form-archivo" enctype="multipart/form-data">
                  <label> SUBIR IMAGEN: </label><input type="file" name="file">
              </form>
              <!--div para visualizar mensajes-->
              <div class="messages"></div><br /><br />
              <!--div para visualizar en el caso de imagen-->
              <div class="showImage"></div>
          </div>

          <div id="paso-4">
                <label  style="font-size:30px">PASO 4) LISTO! ENVIÉ SU REPORTE</label><br> 
                <button id="btn" name="btn" class="btn btn-default"  >ENVIAR</button>
          </div>
      <br>
          <div id="resultado"></div>
  
	
  </div>
</main>