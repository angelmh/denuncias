    $(document).ready(function(){
      
      $(".messages").hide();
    
    var fileExtension = "";
   
    //función que observa los cambios del campo file y obtiene información
    $("input[name='imagen']").change(function() {
        var formData = new FormData( $("#formulario")[0] ); 
       
        var file = $("input[name='imagen']")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring( fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
  
      //  var url = "http://localhost/api/index.php/reportes/";

    });
 
    $('#btn').click( function(event){

        event.preventDefault();

        var formData = new FormData( $("#formulario")[0] ); 
        var message     = ""; 
        var categoria   =   $("#categoria").val();
        var descripcion = $("#descripcion").val();        

     



        var url = "http://localhost/api/index.php/reportes/";

        $.ajax({
            type: 'POST',
            url: url,  
            data: formData,
            contentType: false,
            processData: false,          

            beforeSend: function(){
                message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                showMessage(message);        
            },
            success: function(data){
                message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                showMessage(message);

                if(isImage(fileExtension))
                {
                   $(".showImage").html("<img width='200px' height='200px' src='"+data.response.img+"' />");
                }

            },
            error: function(objError,error){

                console.log(parametros);
                console.log(error);
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });

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

  