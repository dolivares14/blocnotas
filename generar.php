<?php
if(isset($_POST['accion'])){

    if($_POST['accion']=="generartxt"){
        if(isset($_POST['title']) && isset($_POST['text'])){
            if(!empty($_POST['title']) && !empty($_POST['text'])){
                $title = $_POST['title'];
                $text = $_POST['text'];
                $seldire=$_POST['seldire'];
                if($seldire!="Principal"){
                    chdir($seldire);
                }
                $fp =fopen($title,'w');
                fwrite($fp,$text.PHP_EOL);
                fclose($fp);
            }
        }
    }
    elseif($_POST['accion']=="abrirarchivo"){
        if(isset($_POST['selfile'])){
            if(!empty($_POST['selfile'])){
                $file=$_POST['selfile'];
                $fp=fopen($file,'r');
                $cont=fread($fp,filesize($file));
                fclose($fp);
                echo $cont;

            }
        }
    }elseif($_POST['accion']=="creardirectorio"){
        if(isset($_POST['ndire'])){
            if(!empty($_POST['ndire'])){
                $ndire=$_POST['ndire'];
                if(!file_exists($ndire)){
                    mkdir($ndire);
                }
            }
        }
    }
    
}
    

?>