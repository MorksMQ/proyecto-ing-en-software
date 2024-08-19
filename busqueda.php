<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                    echo "<h2>" . $row['nombre'] . "</h2>";
                    echo "<p>" . $row['descripcion'] . "</p>";
                    echo "<p><strong>Costo:</strong> $" . number_format($row['costo'], 2) . "</p>";
                    echo "<img src='imgs/productos/" . $row['imagen'] . "' alt='" . $row['nombre'] . "' style='max-width: 300px; height: auto;'>";
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

</body>
</html>