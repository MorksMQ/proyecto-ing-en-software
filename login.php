<?php
session_start();
include('conexion.php');

$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
} else {
    echo "Usuario o contraseña incorrectos.";
}
$conexion->close();
?>