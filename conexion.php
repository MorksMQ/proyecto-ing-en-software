<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "proyectoingsoft"; 

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->error) {
    die("Conexión fallida: " . $conexion->error);
}
?>