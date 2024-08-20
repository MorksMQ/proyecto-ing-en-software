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
        <div class="logo">
            <img src="imgs/logo.png" alt="aqui va el logo">
        </div>

        <div class="buscador">
        <form method="GET" action="busqueda.php">
            <div class="flex-row"><div>
            <input class="buscador" type="text" name="query" placeholder="Buscar...">
            </div>
            <div>
            <button type="submit"><img class="lupa" src="imgs/icon/busqueda.png" alt="Buscar"></button>
            </div></div>
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
        <div class="bloq1">
        <div class="perfil">
        <a class="boton" href="login.php">
            <img src="imgs/icon/perfil.png" alt="login"></a>
        </div>
        <div class="carrito">
            <a href="#">
                <img src="imgs/icon/carrito.png" alt="carrito">
            </a>
        </div>
        </div>
    </header>
    <nav>
        <div>

        </div>
    </nav>
    <main>
            <div class="heros-section">
                <div>

                </div>
            </div>
            <div class="bloq2">

            </div>
    </main>
    <footer>
        
    </footer>
</body>
</html>