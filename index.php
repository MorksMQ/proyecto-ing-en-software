<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="login">
    <form action="login.php">
        <p>Usuario</p>
        <input name="usuario" id="usuario" type="text" placeholder="Nombre de usuario" required>
        <p>Contraseña</p>
        <input name="contraseña" id="contraseña" type="text" placeholder="Ingresa tu contraseña" required><br>
        <input type="submit" value="Iniciar sesión">
    </form>
    </div>
</body>
</html>