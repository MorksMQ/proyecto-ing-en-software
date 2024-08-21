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
            <a href="index.php">
            <img src="imgs/logo.png" alt="aqui va el logo">
            </a>
        </div>

        <div class="buscador">
            <form method="GET" action="">
                <div class="flex-row">
                    <div>
                        <input class="buscador" type="text" name="query" placeholder="Buscar...">
                    </div>
                    <div>
                        <button type="submit"><img class="lupa" src="imgs/icon/busqueda.png" alt="Buscar"></button>
                    </div>
                </div>
            </form>
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

    <main>
        <div class="view1">
            <?php
            include('conexion.php');

            if (isset($_GET['query'])) {
                $query = $_GET['query'];

                // Protección contra SQL injection
                $query = $conexion->real_escape_string($query);

                // Consulta SQL para buscar en la base de datos
                $sql = "SELECT nombre, descripcion, imagen, costo FROM productos WHERE nombre LIKE '%$query%' OR descripcion LIKE '%$query%'";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='view1'>";
                        echo "<div class='view2'>";
                        echo "<img class='view4' src='imgs/productos/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
                        echo "</div>";
                        echo "<div class='view3'>";
                        echo "<h2 class='a1'>" . $row['nombre'] . "</h2>";
                        echo "<p class='a2'>" . $row['descripcion'] . "</p>";
                        echo "<p class='a3'><strong>Costo:</strong> $" . number_format($row['costo'], 2) . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<hr>";
                        
                    }
                } else {
                    echo "No se encontraron resultados para '$query'.";
                }
            } else {
                echo "Por favor, ingresa un término de búsqueda.";
            }

            $conexion->close();
            ?>
        </div>
    </main>
    
    <footer>
        
    </footer>
</body>
</html>
