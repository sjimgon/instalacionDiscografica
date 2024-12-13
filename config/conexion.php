<?php
require_once "../config/config.php";
function conectar(){
    $conexion = new mysqli(HOST, USER, PASSWORD, NAMEDB, PORT);
    if($conexion->connect_error){
        die("Error de conexión: ".$conexion->connect_error);
    }
    return $conexion;
}
?>