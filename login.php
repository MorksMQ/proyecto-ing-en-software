<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>

    </header>
    <main>
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
        include('conexion.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
                $usuario = $_POST['usuario'];
                $contraseña = $_POST['contraseña'];

                $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if (password_verify($contraseña, $row['contraseña'])) {
                        echo "Inicio de sesión exitoso.";
                        header("Location: dashboard.php");
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
    </main>
    <footer>
        
    </footer>
</body>
</html>