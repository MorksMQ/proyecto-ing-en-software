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
    <header>
        <div class="logo"><img src="imgs/logo.png" alt="aqui va el logo"></div>
        <div class="buscador">
        <form method="GET" action="busqueda.php">
            <input type="text" name="query" placeholder="Buscar...">
            <button type="submit"><img src="imgs/icon/busqueda.png" alt="Buscar"></button>
        </form>

        <?php
            include('conexion.php');

            if (isset($_GET['query'])) {
                $query = $_GET['query'];

                // Protección contra SQL injection
                $query = $conexion->real_escape_string($query);

                // Consulta SQL para buscar en la base de datos
                $sql = "SELECT * FROM productos WHERE nombre LIKE '%$query%' OR descripcion LIKE '%$query%'";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    // Redirigir a otra página si se encuentran resultados
                    header("Location: busqueda.php?query=" . urlencode($query));
                    exit();  
                } else {
                    // Redirigir a una página de "sin resultados"
                    header("Location: errorbusqueda.php?query=" . urlencode($query));
                    exit();
                }
            } else {
                echo "Por favor, ingresa un término de búsqueda.";
            }

            $conexion->close();
        ?>



        </div>
        <a class="boton" href="login.php">Ingresa ahora</a>
    </header>
    <main>

    </main>
    <footer>
        
    </footer>
</body>
</html>