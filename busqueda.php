<?php
    session_start();

    include('conexion.php');
?>
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
<body class="body1">
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
            <div class="agregar">
            <?php
                if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
                    echo "<style type='text/css'> .bloq1{width:300px;} </style>";
                    echo "<a href='añadirproductos.php'><img src='imgs/icon/agregar.png'></a>";
                } else {
                    echo '';
                }
            ?>
            </div>
                <?php
                    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
                        echo "<hr>";
                    } else {
                        echo '';
                    }
                ?>
            <div class="perfil">
                <?php
                if (isset($_SESSION['usuario'])) {
                    echo "<div class='perfil1'>";
                    echo "<div class='perfil2'>";
                    echo "<img src='imgs/icon/perfil.png'>";
                    echo "</div>";
                    echo "<div class='perfil3'>";
                    echo "<p>Hola, </p>";
                    echo "<h3>" . $_SESSION['nombre'] . "!</h3>";
                    echo "<a class='perfil4' href='logout.php'>Cerrar sesión</a>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<a class='perfil3' href='login.php'>";
                    echo "<div class='perfil1'>";
                    echo "<div class='perfil2'>";
                    echo "<img src='imgs/icon/perfil.png'>";
                    echo "</div>";
                    echo "<div>";
                    echo "Bienvenido!";
                    echo "<br>";
                    echo "<p><strong>Inicia sesión</strong></p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>";
                }
                ?>
            </div>
                <hr>
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
    <main class="flex-row flex-wrap justify-around">
        <section class="sec1">
            <div class="buscador1">
                <p>soy un sidebar</p>
                <p>y estoy a la izquierda</p>
            </div>
        </section> 
        <section class="sect2">
            <div class="view1">
                <?php

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
                            // Convertir el BLOB a una imagen base64
                            $imagen_base64 = base64_encode($row['imagen']);
                            $tipo_imagen = 'image/jpeg'; 
                            echo "<img class='view4' src='data:$tipo_imagen;base64,$imagen_base64' alt='" . $row['nombre'] . "'>";
                            echo "</div>";
                            echo "<div class='view3'>";
                            echo "<h2 class='a1'>" . $row['nombre'] . "</h2>";
                            echo "<p class='a2'>" . $row['descripcion'] . "</p>";
                            echo "<p class='a3'><strong>Costo:</strong> $" . number_format($row['costo'], 2) . "</p>";
                            echo "</div>";
                            echo "</div>";
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
        </section>
    </main>
    
    <footer>
        
    </footer>
</body>
</html>
