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
    <div>

    <form action="#" method="POST">
        <p>Usuario</p>
        <input name="usuario" id="usuario" type="text" placeholder="Nombre de usuario" required>

        <p>Correo electrónico</p>
        <input name="email" id="email" type="email" placeholder="Correo electrónico" required>

        <p>Contraseña</p>
        <input name="contraseña" id="contraseña" type="password" placeholder="Ingresa tu contraseña" required>

        <p>Confirmar Contraseña</p>
        <input name="confirmar_contraseña" id="confirmar_contraseña" type="password" placeholder="Confirma tu contraseña" required><br>

        <input type="submit" value="Registrarse"><br>

        <p>Ya tienes cuenta?</p> <a href="login.php">INICIA SESIÓN</a>
    </form>

    <?php
        include('conexion.php');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['contraseña']) && isset($_POST['confirmar_contraseña'])) {
                $usuario = $_POST['usuario'];
                $email = $_POST['email'];
                $contraseña = $_POST['contraseña'];
                $confirmar_contraseña = $_POST['confirmar_contraseña'];

                if ($contraseña !== $confirmar_contraseña) {
                    echo "Las contraseñas no coinciden. Inténtalo de nuevo.";
                } else {
                    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

                    $sql_check = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";
                    $result_check = $conexion->query($sql_check);

                    if ($result_check->num_rows > 0) {
                        echo "El usuario o el correo electrónico ya están registrados.";
                    } else {
                        $sql = "INSERT INTO usuarios (usuario, email, contraseña) VALUES ('$usuario', '$email', '$contraseña_hash')";

                        if ($conexion->query($sql) === TRUE) {
                            echo "Registro exitoso. Ahora puedes iniciar sesión.";
                            header("Location: login.php");
                            exit();
                        } else {
                            echo "Error: " . $sql . "<br>" . $conexion->error;
                        }
                    }
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