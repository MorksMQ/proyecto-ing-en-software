<?php
session_start();

include('conexion.php');
?>

<?php
// Verificar si el usuario está conectado y si es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$mensaje = ""; // Variable para mostrar mensajes

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $categoria = $conexion->real_escape_string($_POST['categoria']);
    $costo = floatval($_POST['costo']);
    $cantidad_en_stock = intval($_POST['cantidad_en_stock']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);

    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen']['tmp_name'];
        
        // Guardar la imagen en la base de datos utilizando send_long_data
        $stmt = $conexion->prepare("INSERT INTO productos (nombre, categoria, costo, cantidad_en_stock, descripcion, imagen) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
        $null = NULL;
        $stmt->bind_param("ssdisb", $nombre, $categoria, $costo, $cantidad_en_stock, $descripcion, $null);
        $fp = fopen($imagen, "r");
        
        while (!feof($fp)) {
            $stmt->send_long_data(5, fread($fp, 8192));
        }
        
        fclose($fp);
        
        if ($stmt->execute()) {
            $mensaje = "Producto añadido exitosamente.";
        } else {
            $mensaje = "Error al añadir el producto: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensaje = "Error al subir la imagen.";
    }

    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

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

    <main>
        <div class="form-container">
            <h2>Añadir Nuevo Producto</h2>

            <?php
            if (!empty($mensaje)) {
                echo "<p>$mensaje</p>";
            }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" required>
                    <option value="figuras">Figuras</option>
                    <option value="camisetas">Camisetas</option>
                    <option value="accesorios">Accesorios</option>
                    <option value="juegos">Juegos</option>
                    <option value="mangas">Mangas</option>
                    <option value="comics">Comics</option>
                    <option value="libros">Libros</option>
                </select>

                <label for="costo">Costo:</label>
                <input type="number" id="costo" name="costo" step="0.01" required>

                <label for="cantidad_en_stock">Cantidad en Stock:</label>
                <input type="number" id="cantidad_en_stock" name="cantidad_en_stock" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>

                <label for="imagen">Imagen del Producto:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>

                <input type="submit" value="Añadir Producto">
            </form>

        </div>
    </main>
</body>
</html>
