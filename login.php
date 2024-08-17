<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="login">
    <form action="#" method="POST">
        <p>Usuario</p>
        <input name="usuario" id="usuario" type="text" placeholder="Nombre de usuario" required>
        <p>Contraseña</p>
        <input name="contraseña" id="contraseña" type="password" placeholder="Ingresa tu contraseña" required><br>
        <input type="submit" value="Iniciar sesión">
        <p>Todavía no tienes una cuenta?!</p> <a href="singup.php">¡Regístrate!</a>
    </form>
    
    <?php
        session_start();
        include('conexion.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {  
                $usuario = $_POST['usuario'];
                $contraseña = $_POST['contraseña'];
        
                $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
                $result = $conexion->query($sql);
        
                if ($result->num_rows > 0) {
                    $_SESSION['username'] = $usuario;  
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Usuario o contraseña incorrectos.";
                }
            } else {
                echo "Por favor, completa ambos campos.";
            }
        }
        $conexion->close();
    ?>
    </div>
</body>
</html>