<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM proveedores WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Datos</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <!--crea la tabla para rellenar con datos de sql -->
        <h2><?php echo $row['nombre']; ?></h2>
        <form method="post" enctype="multipart/form-data">
            <!--<label>ID:</label>
            <input type="text" name="id" value="<?php echo $row['id']; ?>" readonly>-->
            
            <!--<label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" readonly>-->
            
            <!--<label>Tipo de Proveedor:</label>
            <input type="text" name="tipo_proveedor" value="<?php echo $row['tipo_proveedor']; ?>" readonly>-->
            
            <!-- Mostrar la foto actual -->
            <?php
            if ($row['archivo_nombre']) {
                echo "<label>Archivo Actual:</label>";
                echo "<img src='archivos_subidos/".$row['archivo_nombre']."' alt='Foto Actual' style='max-width: 100%;'>";
            }
            ?>
        </form>
    </div>
</body>
</html>