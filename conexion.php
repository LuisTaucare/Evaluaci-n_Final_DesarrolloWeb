<?php

try{
        $server="localhost";
        $user="root";
        $pass="";
        $db="formativa2";

        $cnx = new PDO("mysql:host=$server;dbname=$db",$user,$pass);
        $busqueda=$cnx->prepare("SELECT * FROM producto ");
        $busqueda->execute();
        $resultado = $busqueda->fetchAll();
        //echo "cantidad de registros: ",$busqueda->rowCount();  
        
    }catch(PDOException $err){
        var_dump($err->getMessage());
    };  
date_default_timezone_set("America/santiago");
$fechayhora = date("Y-m-d H:i:s");
echo  $fechayhora;
?>