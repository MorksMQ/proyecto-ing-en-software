<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="login3">
    <!-- <header class="login1">
        <div>
        </div>
    </header> -->
    <!-- <main class="login2"> -->
    <div class="login">
    <form action="#" method="POST">
        <p>Usuario</p>
        <input name="usuario" id="usuario" type="text" placeholder="Ingresa tu Usuario o Correo" required>
        <p>Contraseña</p>
        <input name="contraseña" id="contraseña" type="password" placeholder="Ingresa tu contraseña" required><br>
        <input type="submit" value="Iniciar sesión">
        <p>Todavía no tienes una cuenta?!</p> <a href="singup.php">¡Regístrate!</a>
    </form>
    <?php
        include('conexion.php');
        session_start(); 

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
                $usuario = $_POST['usuario'];
                $contraseña = $_POST['contraseña'];

                // Consulta SQL para verificar el usuario por nickname o correo
                $sql = "SELECT * FROM usuarios WHERE (usuario = '$usuario' OR email = '$usuario')";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Verificar la contraseña
                    if (password_verify($contraseña, $row['contraseña'])) {
                        // Guardar datos del usuario en la sesión
                        $_SESSION['usuario_id'] = $row['id'];
                        $_SESSION['nombre'] = $row['nombre'];  
                        $_SESSION['usuario'] = $row['usuario']; 
                        $_SESSION['apellidos'] = $row['uapellidos'];
                        $_SESSION['direccion'] = $row['direccion'];
                        $_SESSION['fecha_de_nacimiento'] = $row['fecha_de_nacimiento'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['rol'] = $row['rol'];

                        // Redirigir al dashboard u otra página protegida
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "Contraseña incorrecta. Inténtalo de nuevo.";
                    }
                } else {
                    echo "El usuario no existe.";
                }
            } else {
                echo "Por favor, completa todos los campos.";
            }
        }

        $conexion->close();
    ?>

    </div>
    <!-- </main> -->
    <!-- <footer class="login1">
        <div>
        </div>
    </footer> -->
</body>
</html>