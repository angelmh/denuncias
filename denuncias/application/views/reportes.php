  <script type="text/javascript">
        $(document).ready(function() {
    
    //Busqueda Por Categoria
   $("#categoria").on('change',function(event){

        var a = $(this).val();
        if (a != "")
        {
          
        $("input[type='checkbox'][name=ver-todos]").prop("checked",false);
        $("input[type='radio'][name=busqueda-estado]").prop("checked",false);
        $('.Pendiente').remove();
        $('.Enejecucion').remove();
        $('.Resuelta').remove();
        $('.no-hay').remove();
        $('#colonia option[value=""]').prop('selected', 'selected').change();
        $('#avenida option[value=""]').prop('selected', 'selected').change();
        
              var parametros = {'categoria': a };
              var url = "http://localhost/denuncias/index.php/reportes/reporte_categorias";
            $.ajax({
                    type: 'POST',
                    url: url,  
                    data: parametros,
                    success: function(data){
                              console.log(data);
                              var result = JSON.parse(data);
                              if (result.response!=0)
                              {
                                  for (var i =0; i<result.response.length; i++) 
                                  {
                                    var str = result.response[i].estatus;
                                    var res = str.replace(/\s/g,"");
                                    var res = res.replace(/ó/g,"o");
                                    var direccion = result.response[i].calle_avenida+' '+result.response[i].numero+', '+result.response[i].colonia;
                                     var color = "";
                                  if (str=="Pendiente") 
                                  {
                                  color = "color: rgb(177, 63, 59);";
                                  }
                                  else if(str=="En ejecución")
                                  {
                                  color= "color: rgb(255, 202, 0);";
                                  }
                                  else if (str=="Resuelta")
                                  {
                                  color="color: rgb(23, 153, 90);";
                                  }

                                  var estado = '<div class="'+res+'">'+ 
                                              '<table class="table text-center">'+
                                                  '<tr class="panel panel-default" style="border-color: #E9EAED; '+color+'">'+
                                                  '<td>'+
                                                  '<div class="fecha-reporte">'+result.response[i].fecha+'</div> '+
                                                  '<a href="#">'+
                                                    '<img height="230" width="263px" onclick="AbrirReporte(this);" id="'+result.response[i].id+'" src="'+result.response[i].src+'" class="img-rounded">'+
                                                  '</a>'+ 
                                                  '<div class="categoria-reporte">' +result.response[i].categoria+ '</div>'+
                                                  '<div class="direccion-reporte">'+direccion+'</div>'+
                                                  '</td>'+
                                                  '</tr>'+
                                              '</table>'+
                                      '</div>';

                                    $("input[name='ver-todos']").prop("checked",""); 
                                    $('#todos').hide();
                                    $("#todos").after(estado); 
                                  }  
                              }
                              else
                              {
                                    var estado = "<label class='no-hay'>NO HAY REPORTES EN ESTA CATEGORIA </label>";
                                    $('#todos').hide();
                                    $("#todos").after(estado); 
                              }
                            
                               
                    },
                    beforeSend: function(){ $('#wait').show(); },
                    complete: function() { $('#wait').hide(); },
                    error: function(objError,error){
                              console.log("Existe un error"+objError+error);
                              //window.location = 'http://localhost/service/';
                           }
            });

        }
   });

    //Busqueda Por Colonia
   $("#colonia").on('change',function(event){

        var a = $(this).val();
        if (a != "")
        {
        $("input[type='checkbox'][name=ver-todos]").prop("checked",false);
        $("input[type='radio'][name=busqueda-estado]").prop("checked",false);
        $('.Pendiente').remove();
        $('.Enejecucion').remove();
        $('.Resuelta').remove();
        $('.no-hay').remove();
        $('#categoria option[value=""]').prop('selected', 'selected').change();
        $('#avenida option[value=""]').prop('selected', 'selected').change();
        
            var a=  encodeURIComponent(a);
            var parametros = {'colonia': a };
            var url = "http://localhost/denuncias/index.php/reportes/reporte_colonias";
          $.ajax({
                  type: 'POST',
                  url: url,  
                  data: parametros,
                  success: function(data){
                           // console.log(data);
                            var result = JSON.parse(data);
                            for (var i =0; i<result.response.length; i++) 
                            {
                              var str = result.response[i].estatus;
                              var res = str.replace(/\s/g,"");
                              var res = res.replace(/ó/g,"o");
                              var direccion = result.response[i].calle_avenida+' '+result.response[i].numero+', '+result.response[i].colonia;
                               var color = "";
                              if (str=="Pendiente") 
                              {
                                color = "color: rgb(177, 63, 59);";
                              }
                              else if(str=="En ejecución")
                              {
                                color= "color: rgb(255, 202, 0);";
                              }
                              else if (str=="Resuelta") 
                              {
                               color="color: rgb(23, 153, 90);";
                              }

                                var estado = '<div class="'+res+'">'+ 
                                            '<table class="table text-center">'+
                                                '<tr class="panel panel-default" style="border-color: #E9EAED; '+color+'">'+
                                                '<td>'+
                                                '<div class="fecha-reporte">'+result.response[i].fecha+'</div> '+
                                                '<a href="#">'+
                                                  '<img height="230" width="263px" onclick="AbrirReporte(this);" id="'+result.response[i].id+'" src="'+result.response[i].src+'" class="img-rounded">'+
                                                '</a>'+ 
                                                '<div class="categoria-reporte">' +result.response[i].categoria+ '</div>'+
                                                '<div class="direccion-reporte">'+direccion+'</div>'+
                                                '</td>'+
                                                '</tr>'+
                                            '</table>'+
                                    '</div>';

                              $("input[name='ver-todos']").prop("checked",""); 
                              $('#todos').hide();
                              $("#todos").after(estado); 
                            }
                          
                             
                  },
                  beforeSend: function(){ $('#wait').show(); },
                  complete: function() { $('#wait').hide(); },
                  error: function(objError,error){
                            console.log("Existe un error"+objError+error);
                            window.location = 'http://localhost/denuncias/';
                         }
          });
        }

        
   });
       

    //Busqueda Por Avenida
   $("#avenida").on('change',function(event){

        var a = $(this).val();
        if (a != "")
        {
        $("input[type='checkbox'][name=ver-todos]").prop("checked",false);
        $("input[type='radio'][name=busqueda-estado]").prop("checked",false);
        $('.Pendiente').remove();
        $('.Enejecucion').remove();
        $('.Resuelta').remove();
        $('.no-hay').remove();
        
        
        $('#colonia option[value=""]').prop('selected', 'selected').change();
        $('#categoria option[value=""]').prop('selected', 'selected').change();
            var a=  encodeURIComponent(a);
            var parametros = {'avenida': a };
          
            var url = "http://localhost/denuncias/index.php/reportes/reporte_avenidas";
          $.ajax({
                  type: 'POST',
                  url: url,  
                  data: parametros,
                  success: function(data){
                            //console.log(data);
                            var result = JSON.parse(data);
                            for (var i =0; i<result.response.length; i++) 
                            {
                              var str = result.response[i].estatus;
                              var res = str.replace(/\s/g,"");
                              var res = res.replace(/ó/g,"o");
                              var direccion = result.response[i].calle_avenida+' '+result.response[i].numero+', '+result.response[i].colonia;
                              var color = "";
                              if (str=="Pendiente") 
                              {
                                color = "color: rgb(177, 63, 59);";
                              }
                              else if(str=="En ejecución")
                              {
                                color= "color: rgb(255, 202, 0);";
                              }
                              else if (str=="Resuelta") 
                              {
                               color="color: rgb(23, 153, 90);";
                              }

                                var estado = '<div class="'+res+'">'+ 
                                            '<table class="table text-center">'+
                                                '<tr class="panel panel-default" style="border-color: #E9EAED; '+color+'">'+
                                                '<td>'+
                                                '<div class="fecha-reporte">'+result.response[i].fecha+'</div> '+
                                                '<a href="#">'+
                                                  '<img height="230" width="263px" onclick="AbrirReporte(this);" id="'+result.response[i].id+'" src="'+result.response[i].src+'" class="img-rounded">'+
                                                '</a>'+
                                                '<div class="categoria-reporte">' +result.response[i].categoria+ '</div>'+
                                                '<div class="direccion-reporte">'+direccion+'</div>'+
                                                '</td>'+
                                                '</tr>'+
                                            '</table>'+
                                    '</div>';
                               

                              $("input[name='ver-todos']").prop("checked",""); 
                              $('#todos').hide();
                              $("#todos").after(estado); 
                            }
                          
                             
                  },
                  beforeSend: function(){ $('#wait').show(); },
                  complete: function() { $('#wait').hide(); },
                  error: function(objError,error){
                            console.log("Existe un error"+objError+error);
                            window.location = 'http://localhost/denuncias/';
                         }
          });
        }

        
   });
            
            $("input[type='checkbox'][name=ver-todos]").on('change',function(event){
               $('#colonia option[value=""]').prop('selected', 'selected').change();
                  $('#avenida option[value=""]').prop('selected', 'selected').change();
                  $('#categoria option[value=""]').prop('selected', 'selected').change();
   
                  $("input[type='radio'][name=busqueda-estado]").prop("checked",false);
                  $('.Pendiente').remove();
                  $('.Enejecucion').remove();
                  $('.Resuelta').remove();
                  $('#todos').show();
            });

            //Busqueda Por Estatus
            $("input[type='radio'][name=busqueda-estado]").on('change',function(event){
                event.preventDefault();
                var a = $(this).val();
                
                console.log(a);
                      // console.log(this.firstElementChild);
                      //console.log(this.lastElementChild);
                      //  console.log(this.childNodes[3]);
                if (a != "")
                {
                  
                $("input[type='checkbox'][name=ver-todos]").prop("checked",false);
                $('.Pendiente').remove();
                $('.Enejecucion').remove();
                $('.Resuelta').remove();
                $('.no-hay').remove();
        
                  $('#colonia option[value=""]').prop('selected', 'selected').change();
                  $('#avenida option[value=""]').prop('selected', 'selected').change();
                  $('#categoria option[value=""]').prop('selected', 'selected').change();
   
                  var parametros = {'b-estado': a };
                  var url = "http://localhost/denuncias/index.php/reportes/reporte_estatus";

                $.ajax({

                      type: 'POST',
                      url: url,  
                      data: parametros,
                      success: function(data){
                      
                      var result = JSON.parse(data);
                      
                      //if( typeof(result.error) == "undefined"){
                          
                          //console.log(result.response);
                          for (var i =0; i<result.response.length; i++) {
                           // primero imprime el objeto 0, despues el 1

                          /*};
                          for(var i in result.response)
                          {*/
                          
                            var str = result.response[i].estatus;
                            var res = str.replace(/\s/g,"");
                            var res = res.replace(/ó/g,"o");
                            var direccion = result.response[i].calle_avenida+' '+result.response[i].numero+', '+result.response[i].colonia;
                            var color = "";
                            if (str=="Pendiente") 
                          {
                            color = "color: rgb(177, 63, 59);";
                          }
                          else if(str=="En ejecución"){
                            
                            color= "color: rgb(255, 202, 0);";
                          }
                          else if (str=="Resuelta") {
                           
                            color="color: rgb(23, 153, 90);";
                          }

                            var estado = '<div class="'+res+'">'+ 
                                        '<table class="table text-center">'+
                                            '<tr class="panel panel-default" style="border-color: #E9EAED; '+color+'">'+
                                            '<td>'+
                                            '<div class="fecha-reporte">'+result.response[i].fecha+'</div> '+
                                            '<a href="#">'+
                                              '<img height="230" width="263px" onclick="AbrirReporte(this);" id="'+result.response[i].id+'" src="'+result.response[i].src+'" class="img-rounded">'+
                                            '</a>'+ 
                                            '<div class="categoria-reporte">' +result.response[i].categoria+ '</div>'+
                                            '<div class="direccion-reporte">'+direccion+'</div>'+
                                            '</td>'+
                                            '</tr>'+
                                        '</table>'+
                                '</div>';

                                  /*console.log(result.response[i].id);
                                  console.log(result.response[i].estado);
                                  console.log(result.response[i].categoria);
                                  console.log(result.response[i].descripcion);
                                  console.log(result.response[i].img);
                                  console.log(result.response[i].latitud);
                                  console.log(result.response[i].longitud);
                                  console.log(result.response[i].fecha);*/
                            
                            $("input[name='ver-todos']").prop("checked",""); 
                            $('#todos').hide();
                            $("#todos").after(estado); 
                          }
                     
                      /*}
                      else 
                      {   
                          $("input[type='checkbox'][name=ver-todos]").prop("checked",false);
                          $('.Pendiente').remove();
                          $('.Enejecucion').remove();
                          $('.Resuelta').remove();
                          $('#todos').hide();
                          $("input[name='ver-todos']").prop("checked",""); 
                      }*/
                      


                    },
                    beforeSend: function(){ $('#wait').show(); },
                    complete: function() { $('#wait').hide(); },
                    error: function(objError,error){
                              console.log("Existe un error"+objError+error);
                              window.location = 'http://localhost/denuncias/';
                           }
                      });
                }
              

            });


        });
             
        </script>
        
        <script type="text/javascript">
          function AbrirReporte(image)
          {
              console.log(image.src);
              var src = image.src;
              var id = image.id;
              var $image = $('<div></div>');
              
              window =  window.location = 'http://localhost/denuncias/index.php/reportes/reporte/'+id;  
               /* $image.append('<center><img height="230" class="img-rounded" width="230px" src="'+src+'" /></center>');

                BootstrapDialog.show({
                    title: 'Reporte',
                    message: $image,
                    buttons: [{
                        label: 'Close',
                        action: function(dialogRef){
                            dialogRef.close();
                        }
                      }
                    ]
                });*/

          }
                  </script>

    <style type="text/css">

      .panel
      {
        border: 10px solid transparent;
      }

      #wait
      {
    display:    none;
    position:   absolute;
    z-index:    1000;
    height:     24px;
    width:      24px;
    background: rgba( 255, 255, 255, .8 ) 
                url('<?php echo base_url();?>img/loader/cargando2.gif') 
               
                no-repeat;
    }
    #estatus{
     width: 10px;
     height: 10px;
     -moz-border-radius: 50%;
     -webkit-border-radius: 50%;
     border-radius: 50%;
    }
    </style>

<script type="text/javascript">

</script>


<main class="page-row page-row-expanded"  style="    background-color: #E9EAED;">
  <div class="container">
  <br><br><br>   
              <div class="col-md-offset-1 col-md-10">
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="categoria">Dependencia: </label>
                      <select class="selectpicker" data-live-search="true" title=" " id="categoria" name="categoria">
                        <option data-hidden="true" value="" id="categoria-option" name="categoria-option"></option>
                      <?php foreach ($categorias['response'] as $key => $value) { ?>
                        <option value="<?php  echo $categorias['response'][$key]['id']; ?>"  data-tokens="<?php  echo $categorias['response'][$key]['categoria']; ?>"><?php  echo $categorias['response'][$key]['categoria']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div  class="col-md-4">
                  <div class="form-group">
                    <label for="avenida">Avenida: </label>
                    <select class="selectpicker" data-live-search="true"  title=" " id="avenida" name="avenida">
                       <option data-hidden="true" value="" id="avenida-option" name="avenida-option" ></option>
                      <?php foreach ($calles['calles'] as $key => $value) { ?>
                      <option value="<?php  echo $calles['calles'][$key]['calle_avenida']; ?>" data-tokens="<?php  echo $calles['calles'][$key]['calle_avenida']; ?>"><?php  echo $calles['calles'][$key]['calle_avenida']; ?></option>
                      <?php } ?>
                    </select>
                  </div> 
                </div>
                <div  class="col-md-4">
                    <div class="form-group">
                      <label for="colonia">Colonia: </label>
                       <select  class="selectpicker" data-live-search="true"   title=" " id="colonia" name="colonia">

                         <option data-hidden="true" value="" id="colonia-option" name="colonia-option"> </option>
                        <?php foreach ($colonias['colonias'] as $key => $value) { ?>
                        <option value="<?php  echo $colonias['colonias'][$key]['colonia']; ?>"  data-tokens="<?php  echo $colonias['colonias'][$key]['colonia']; ?>"> <?php  echo $colonias['colonias'][$key]['colonia']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                 
                  <form role="form">
                    <label for="b-estatus">Estatus:</label>
                    <label class="radio-inline">
                          <input type="radio" name="busqueda-estado" value="1">Pendiente
                    </label>
                    <label class="radio-inline">
                          <input type="radio" name="busqueda-estado" value="2">En ejecución
                    </label>
                    <label class="radio-inline">
                          <input type="radio" name="busqueda-estado" value="3">Resuelta
                    </label><BR>
                    <label for="ver-todos">Todos los reportes:</label>
                    <input type="checkbox" name="ver-todos" id="ver-todos" >
                    <div id="wait"></div>
                  </form><br><br>
              </div>

               
    <div class="col-md-offset-1 col-md-10">
        <?php if( !isset($error) ){ ?>
              <div id="todos">
                  
                
                    <?php foreach ($response as $key => $value) {    ?>
                
                    <!--  
                      <div class="col-md-4" id="reporte<?php echo $response[$key]['id']; ?>" style="margin-bottom:2%">
                            
                              <a href="#">
                                  <img  onclick="AbrirReporte(this);" height="230" width="263px" id="<?php echo $response[$key]['id'] ?>" src="<?php echo $response[$key]['src']; ?>" class="img-rounded">
                              </a> 
                              Fecha del reporte: <div class="fecha-reporte"><?php echo $response[$key]['fecha']; ?></div> -->
                              <!-- Reportado por: <div class="reportado-por"><?php echo $response[$key]['name']; ?></div>  -->
                              <!-- Estatus:  <div class="estatus-reporte"><?php echo $response[$key]['estatus']; ?></div>-->
                               
                              <!-- Descripción: <div class="descripcion-reporte"><?php echo $response[$key]['descripcion']; ?></div> 
                            <div class="direccion-reporte"><?php echo $response[$key]['calle_avenida']." ".$response[$key]['numero'].", ".$response[$key]['colonia'];; ?></div> 
                      </div>
                            -->
                  <table class="table text-center">
                    <tr class="panel panel-default" style="border-color: #E9EAED;">
                      <td <?php 

                          if ($response[$key]['estatus']=="Pendiente") 
                          {
                            echo " style='color: rgb(177, 63, 59); '";
                          }
                          else if($response[$key]['estatus']=="En ejecución"){
                            echo " style='color: rgb(255, 202, 0) '";
                          }
                          else if ($response[$key]['estatus']=="Resuelta") {
                            echo " style='color:  rgb(23, 153, 90); '";
                          
                          }
                           ?>
                           > 
                          <div class="fecha-reporte"><?php echo $response[$key]['fecha']; ?>
                            
                         </div> 
                          <a href="#">
                                    <img  onclick="AbrirReporte(this);" height="230" width="263px" id="<?php echo $response[$key]['id'] ?>" src="<?php echo $response[$key]['src']; ?>" class="img-rounded">
                          </a>
                          <div class="categoria-reporte"><?php echo $response[$key]['categoria']; ?></div>
                          <div class="direccion-reporte"><?php echo $response[$key]['calle_avenida']." ".$response[$key]['numero'].", ".$response[$key]['colonia']; ?>

                            

                          </div> 
                          
                      </td>
                    </tr>
                  </table>

                  <?php } // fin foreach ?>
                   </div> 
                    
                
                



      <?php  }
            else
            { ?>
      <script type="text/javascript">
      alert('No hay reportes');
      </script>
      <?php  
           } 
      ?>
      </div>
         
     

      </div>


  </div>

</main>
