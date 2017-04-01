<main class="page-row page-row-expanded"  style="background-color: #E9EAED;">
  <div class="container">
  <br><br><br><br><br><br>
    
      <style type="text/css">
      #comments-container {
        padding: 20px;
        margin: 0px;
        font-size: 14px;
        font-family: "Arial", Georgia, Serif;
      }
    </style>
    <script type="text/javascript">

    $(document).ready(function(){

        
        var reporte =  $("#reporte").val();
        var usr =  $("#user").val();
        total_reporte();


        //VOTAR Y CANCELAR VOTO
        if( typeof(usr) != "undefined")
        {
                  $("#cancelar-apoyo").hide();
                  $("#apoyar").hide();
                  var usuario = "<?php echo $this->session->userdata('usuario');  ?>";
                  var parametros = {
                          'reporte': reporte,
                          'usuario': usuario
                          };
                  var url = "http://localhost/denuncias/index.php/reportes/votos";
                  //DETECTAR SI SE APOYÓ EL REPORTE
                  $.ajax({
                  type: 'POST',
                  data: parametros,
                  url: url,  
                  success: function(data){
                            console.log(data);
                            var result = JSON.parse(data);
                            if (result.is_true==true)
                            {
                              var inputhide = "<input type='hidden' id='id-voto' value='"+result.voto.id+"'>";
                              $('#cancelar-apoyo').after(inputhide);
                              
                                if (result.voto.cantidad==1) 
                                {
                                  
                                  // poder cancelar en el mismo registro
                                  $("#cancelar-apoyo").show();
                                }
                                else if(result.voto.cantidad==0)
                                {
                                    //poder votar en el mismo registro
                                    $("#apoyar").show();
                                }
                            }
                            else
                            {
                                //Poder votar en registro nuevo
                                $("#apoyar").show();
                            }
                  },
                  error: function(objError,error){
                            console.log("Existe un error"+objError+error);
                          
                         }
                  });


                  ///APOYAR REPORTE
                
                  $('#apoyar').click( function(event){
                        var voto =  $("#id-voto").val();
                        var reporte =  $("#reporte").val();
                        var usuario = "<?php echo $this->session->userdata('usuario');  ?>";
                        

                        if( typeof(voto) != "undefined")
                        {
                              //Actualizar registro del voto existente
                              var parametros = {
                                                'voto': voto
                                                };

                              var url = "http://localhost/denuncias/index.php/reportes/actualizarvoto";
                             
                              $.ajax({
                                type: 'POST',
                                url: url,  
                                data: parametros,
                                success: function(data)
                                {
                                          console.log(data);
                                          var result = JSON.parse(data);
                                          if (result.response!=0)
                                          {
                                            console.log(result.response);
                                            esconder_btn_apoyo();
                                            total_reporte();
                                          }
                                },
                                error: function(objError,error){
                                          console.log("Existe un error"+objError+error);
                                          alert("error al enviar...");
                                       }
                                });
                        }
                        else
                        {
                              //Crear Nuevo
                              var url = "http://localhost/denuncias/index.php/reportes/votar";
                              var parametros = {
                                              'reporte': reporte,
                                              'usuario': usuario
                                              };
                              $.ajax({
                                type: 'POST',
                                url: url,  
                                data: parametros,
                                success: function(data){
                                        var result = JSON.parse(data);
                                        if (result.response!=0)
                                        {
                                          console.log(result.response);
                                          var voto = result.response;
                                          var inputhide = "<input type='hidden' id='id-voto' value='"+voto+"'>";
                                          $('#cancelar-apoyo').after(inputhide);
                                          esconder_btn_apoyo();
                                          total_reporte();
                                        }
                                },
                                error: function(objError,error){
                                        console.log("Existe un error"+objError+error);
                                      
                                     }
                                });
                        }
                    
                  }); 
                  
                  
                function esconder_btn_apoyo()
                {
                  $("#apoyar").hide();
                  $("#cancelar-apoyo").show();
                }

                function esconder_btn_cancelar()
                {
                  $("#cancelar-apoyo").hide();
                  $("#apoyar").show();
                }
                

                //CANCELAR REPORTE
                $('#cancelar-apoyo').click( function(event){
                          var voto =  $("#id-voto").val();
                          var parametros = {
                                              'voto': voto
                                              };

                            var url = "http://localhost/denuncias/index.php/reportes/cancelarvoto";
                            $.ajax({
                              type: 'POST',
                              url: url,  
                              data: parametros,
                              success: function(data){
                                        console.log(data);
                                        
                                        var result = JSON.parse(data);
                                        if (result.response!=0)
                                        {
                                            console.log(result.response);
                                            esconder_btn_cancelar();
                                            total_reporte();
                                        }
                              },
                              error: function(objError,error){
                                        console.log("Existe un error"+objError+error);
                                        alert("error al enviar...");
                                     }
                              });
                });
                  
                
                    
                  
                  
        }
        else
        {
          alert("Inicia sesion para poder apoyar este reporte.");
        }

        function total_reporte()
        {
                  var reporte =  $("#reporte").val();
                  console.log(" r: "+reporte);
                  var parametros = {
                                    'reporte': reporte
                                   };

                  var url = "http://localhost/denuncias/index.php/reportes/cantidadvotos";
                  //DETECTAR SI SE APOYÓ EL REPORTE
                  $.ajax({
                  type: 'POST',
                  data: parametros,
                  url: url,  
                  success: function(data){
                            var result = JSON.parse(data);
                            console.log("t: "+result.cantidad.total);
                            if (result.cantidad.total == null)
                            {
                              result.cantidad.total = 0;
                            }
                            
                            $("#total-apoyo").html("<label>Comunidad apoyando: "+result.cantidad.total+"</label>");

                  },
                  error: function(objError,error){
                            console.log("Existe un error"+objError+error);
                          
                         }
                  });

        }
                            
              
});
    
 
    </script>

  <!-- Init jquery-comments -->
  <!-- <script type="text/javascript">
      $(function() {
        $('#comments-container').comments({
          profilePictureURL: 'https://viima-app.s3.amazonaws.com/media/user_profiles/user-icon.png',
          roundProfilePictures: true,
          textareaRows: 1,
          enableAttachments: true,
          getComments: function(success, error) {
            setTimeout(function() {

              success(commentsArray);

            }, 500);
          },
          postComment: function(data, success, error) {

            setTimeout(function() {
              console.log(data);
              success(data);
            }, 500);

          },
          putComment: function(data, success, error) {

            setTimeout(function() {
              console.log(data);
              success(data);
            }, 500);

          },
          deleteComment: function(data, success, error) {
            setTimeout(function() {
              success();
            }, 500);
          },
          upvoteComment: function(data, success, error) {

            setTimeout(function() {
              console.log(data);
              success(data);
            }, 500);

          },

          uploadAttachments: function(dataArray, success, error) {
            setTimeout(function() {
              success(dataArray);
            }, 500);
          },
        });
      });
    </script>-->

    <center>
            <div id="reporte<?php echo $response['id']; ?>">
              <label>Dependencia:  </label><div class="categoria-reporte"><?php echo $response['categoria']; ?></div>
              <label>Estatus: </label><div class="estatus-reporte"><?php echo $response['estatus']; ?></div>
              <img src=" <?php echo $response['src']; ?>" class="img-rounded" style="width: 50%; height: 50%;"><br>
              <div id="total-apoyo" style="font-size: 30px;"></div>
              <input type="hidden" value="<?php echo $response['id']; ?>" id="reporte">
              <?php if (!is_null($this->session->userdata('usuario'))){ ?> 
              <input type="hidden" id="user" value="<?php echo $this->session->userdata('usuario');  ?>" >
              <button  id="apoyar">Apoyar</button><br>     
              <button id="cancelar-apoyo">Cancelar Apoyo</button><br>  
              <?php    
                  }  
              ?>
              
              <label>Fecha: </label><div class="fecha-reporte"><?php echo $response['fecha']; ?></div> 
              <label>Reportado por: </label><div class="reportado-por"><?php echo $response['name']; ?></div>  
           <!--<label>Dirección: </label><div class="direccion-reporte"><?php echo $response['calle_avenida']." ".$response['numero'].", ".$response['colonia'];; ?></div>
                <label>Descripción: </label><div class="descripcion-reporte"><?php echo $response['descripcion']; ?></div>
            -->
            </div>

    </center>
     <div id="comments-container"></div>

     <div id="disqus_thread"></div>
<script>
/**
* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');

s.src = '//denunciaciudadana.disqus.com/embed.js';

s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>


<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
  </div>
</main>