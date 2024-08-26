<!-- Despues de un chingo de errores lo cambie para aca arriba para verificar el usuario y para que funcionara a la hora de buscar
 no que que onda con los codigos pero no me dejaba ponerlos por separado asi que los uni
 :_.   TmT ya me canse
 -->

<?php
session_start(); 

include('conexion.php');
?>

<?php
// Verifica si hay una búsqueda activa
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
}

$conexion->close();
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
            <form method="GET" action="busqueda.php">
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
        <div></div>
    </nav>

    <main>
        <div class="heros-section">
            <div></div>
        </div>
        <div class="bloq2">
        <?php
            include('conexion.php');

            $sql = "SELECT id_producto, nombre, costo, imagen FROM productos";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='productos-container'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='producto-tarjeta'>";
                    echo "<img class='view4' src='data:image/jpeg;base64," . base64_encode($row['imagen']) . "' alt='" . $row['nombre'] . "'>";
                    echo "<h2>" . $row['nombre'] . "</h2>";
                    echo "<p><strong>Costo:</strong> $" . number_format($row['costo'], 2) . "</p>";
                    echo "<a href='producto.php?id=" . $row['id_producto'] . "' class='boton1'>Ver Producto</a>";
                    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
                        echo "<div class='botones1'>";
                        echo "<a href='editarproducto.php?id=" . $row['id_producto'] . "' class='boton2'><img src='imgs/icon/editar.png'></a>";
                        echo "<a href='eliminarproducto.php?id=" . $row['id_producto'] . "' class='boton3'><img src='imgs/icon/eliminar.png'></a>";
                        echo "</div>";
                    } else {
                        echo "";
                    }

                    echo "</div>";
                }                
                echo "</div>";
            } else {
                echo "No hay productos disponibles.";   
            }

            $conexion->close();
        ?>

        </div>
    </main>

    <footer></footer>
</body>
</html>
