<?php
session_start();

// Verificar si el usuario está conectado y si es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    
    header("Location: logout.php");
    exit();
}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir productos</title>
</head>
<body>
    
</body>
</html>