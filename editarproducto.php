<?php
session_start();

include('conexion.php');

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$mensaje = ""; 
$editing = false; 

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $editing = true;

    $stmt = $conexion->prepare("SELECT nombre, categoria, costo, cantidad_en_stock, descripcion FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $stmt->bind_result($nombre, $categoria, $costo, $cantidad_en_stock, $descripcion);
    $stmt->fetch();
    $stmt->close();
} else {
    $nombre = "";
    $categoria = "";
    $costo = 0;
    $cantidad_en_stock = 0;
    $descripcion = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $categoria = $conexion->real_escape_string($_POST['categoria']);
    $costo = floatval($_POST['costo']);
    $cantidad_en_stock = intval($_POST['cantidad_en_stock']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);

    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen']['tmp_name'];
    }

    if ($editing) {

        if ($imagen) {
            $stmt = $conexion->prepare("UPDATE productos SET nombre = ?, categoria = ?, costo = ?, cantidad_en_stock = ?, descripcion = ?, imagen = ? WHERE id_producto = ?");
            $null = NULL;
            $stmt->bind_param("ssdisbi", $nombre, $categoria, $costo, $cantidad_en_stock, $descripcion, $null, $id_producto);
            $fp = fopen($imagen, "r");
            
            while (!feof($fp)) {
                $stmt->send_long_data(5, fread($fp, 8192));
            }
            fclose($fp);
        } else {
            $stmt = $conexion->prepare("UPDATE productos SET nombre = ?, categoria = ?, costo = ?, cantidad_en_stock = ?, descripcion = ? WHERE id_producto = ?");
            $stmt->bind_param("ssdisi", $nombre, $categoria, $costo, $cantidad_en_stock, $descripcion, $id_producto);
        }

        if ($stmt->execute()) {
            $mensaje = "Producto actualizado exitosamente.";
        } else {
            $mensaje = "Error al actualizar el producto: " . $stmt->error;
        }
    } else {

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
    }

    $stmt->close();
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $editing ? "Editar Producto" : "Añadir Producto"; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2><?php echo $editing ? "Editar Producto" : "Añadir Nuevo Producto"; ?></h2>

    <?php
    if (!empty($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="figuras" <?php echo $categoria == "figuras" ? "selected" : ""; ?>>Figuras</option>
            <option value="camisetas" <?php echo $categoria == "camisetas" ? "selected" : ""; ?>>Camisetas</option>
            <option value="accesorios" <?php echo $categoria == "accesorios" ? "selected" : ""; ?>>Accesorios</option>
            <option value="juegos" <?php echo $categoria == "juegos" ? "selected" : ""; ?>>Juegos</option>
            <option value="mangas" <?php echo $categoria == "mangas" ? "selected" : ""; ?>>Mangas</option>
            <option value="comics" <?php echo $categoria == "comics" ? "selected" : ""; ?>>Comics</option>
            <option value="libros" <?php echo $categoria == "libros" ? "selected" : ""; ?>>Libros</option>
        </select>

        <label for="costo">Costo:</label>
        <input type="number" id="costo" name="costo" step="0.01" value="<?php echo htmlspecialchars($costo); ?>" required>

        <label for="cantidad_en_stock">Cantidad en Stock:</label>
        <input type="number" id="cantidad_en_stock" name="cantidad_en_stock" value="<?php echo htmlspecialchars($cantidad_en_stock); ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea>

        <label for="imagen">Imagen del Producto:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" <?php echo $editing ? "" : "required"; ?>>

        <input type="submit" value="<?php echo $editing ? "Actualizar Producto" : "Añadir Producto"; ?>">
    </form>

</div>
</body>
</html>
