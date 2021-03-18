<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/estilo.css">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    var archivoabierto=false;
    function guardartxt(title,text,seldire){
        if(title.includes('.txt')){
            var mensajeconfirm="";
        if(archivoabierto==false){
            mensajeconfirm="¿Deseas crear este archivo?";
        }else{
            mensajeconfirm="¿Deseas guardar los cambios a este archivo?";
        }
        var opcion=confirm(mensajeconfirm);
        if(opcion==true){
            var valores={
            "title":title,
            "accion":"generartxt",
            "text":text,
            "seldire":seldire
        }
        $.ajax({
                    url:"generar.php",
                    type: "post",
                    data: valores,

                    beforeSend: function() {
                        
                    },
                    fail: function() {
                        
                    },
                    success: function(response) {
                        document.getElementById("title").value="";
                        document.getElementById("text").value="";
                        archivoabierto=false;
                        alert("¡Archivo creado exitosamente!");
                        var cont= document.getElementById("resp");
                        cont.innerHTML =response;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });     
        }

        }else{
            alert("ERROR: escriba el titulo segun este formato: ejemplo.txt");
        }
        
    }
    
    
</script>
<script>
    function openf(selfile){
        var opcion = confirm("¿Esta seguro que desea abrir este archivo?");
        if(opcion==true){
            var valores={
            "accion":"abrirarchivo",
            "selfile":selfile
        }
        $.ajax({
                    url:"generar.php",
                    type: "post",
                    data: valores,

                    beforeSend: function() {
                        
                    },
                    fail: function() {
                        
                    },
                    success: function(response) {
                        document.getElementById("title").value=selfile;
                        document.getElementById("text").value=response;   
                        archivoabierto=true;   
                        alert("¡Archivo abierto exitosamente!");             
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
        }
    }
    function newdire(ndire){
        var opcion = confirm("¿Estas seguro que deseas crear esta carpeta?");
        if(opcion==true){
            var valores={
            "accion":"creardirectorio",
            "ndire":ndire
        }
        $.ajax({
                    url:"generar.php",
                    type: "post",
                    data: valores,

                    beforeSend: function() {
                        
                    },
                    fail: function() {
                        
                    },
                    success: function() {
                        alert("¡directorio creado exitosamente!");                       
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
        }   
    }
</script>

 <title>Bloc de notas</title>
</head>
<body class="parallax">
    <div class="container" style=" width:600px;opacity: 0.95;background-color: white;margin-top:3%">
    <div class="row" style="margin-bottom:3%;margin-top:3%;margin-left:1%">
        <button class="btn btn-outline-warning" style="margin-right:3%" type="button" data-toggle="collapse" data-target="#form-group1" aria-expanded="false" aria-controls="#form-group1">Mostrar/ocultar abrir archivos</button>
        <button class="btn btn-outline-warning" type="button" data-toggle="collapse" data-target="#form-group2" aria-expanded="false" aria-controls="#form-group2">Mostrar/ocultar crear nueva carpeta</button>  
    </div>
    
    <div class="form-group collapse row" style="margin-left:1%" id="form-group1">
    <select  class="form-control" id="selfile" style="width:200px;margin-right:3%">
      <option>principal</option>
      <?php
         
         function rellenar($dir){
            $maindir= opendir($dir);
            while(($carp=readdir($maindir))!==false){ 
               if(!is_dir($carp)){
                   $block1=strpos($carp,".php");
                   $block2=strpos($carp,".html");
                   if ($block1===false && $block2 ===false){
                    echo '<option>'.$carp.'</option>';
                   }
                }else{
                    if($carp != "." && $carp != ".." && $carp != "css" && $carp != "img"){
                        echo '<option>'.$carp.'</option>';
                        rellenar($carp);
                    }
                }
            }  
        }
        rellenar(getcwd());
         
      ?>
    </select>
    <button onclick="openf($('#selfile').val())" type="submit" class="btn btn-outline-warning">Abrir archivo</button>
  </div>

  

  <div class="form-group collapse row" style="margin-left:1%" id="form-group2">
    <input type="text" id="ndire" class="form-control" placeholder="nombre del directorio" style="width:200px;margin-right:3%">
    <button onclick="newdire($('#ndire').val())" type="submit" class="btn btn-outline-warning">nuevo</button>
  </div>
    
 <div class="row">
     <label class="text-warning" style="margin-right:25%; margin-left:5%">Directorio</label>
     <label class="text-warning">Nombre del archivo</label>
</div>

 <div class="form-group row" style="margin-left:1%">
 <select  class="form-control" id="seldire"  style="width:200px; margin-right:3%">
      <option>Principal</option>
      <?php
         $maindir= opendir(getcwd());
         while(($carp=readdir($maindir))!==false){ 
             if(is_dir($carp)){
                if($carp != "." && $carp != ".." && $carp != "css" && $carp != "img"){
                    echo '<option>'.$carp.'</option>';
                }
             }   
         }
      ?>
 </select>
     <input type="text" id="title" class="form-control" style="width:200px;margin-right:3%" name="title" placeholder="ejemplo:(ejemplo.txt)" width="500px;">
     <button onclick="guardartxt($('#title').val(),$('#text').val(),$('#seldire').val())" name="env" style="margin-bottom:3%" class="btn btn-outline-warning">Guardar</button>
 </div>
 <textarea class="form-control" id="text" name="text" style="width: 570px;height: 300px;"></textarea>
 <br />

</div>
  
</body>
</html>