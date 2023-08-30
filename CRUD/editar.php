<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['submit'])) {
        $nombre = $_POST['nombre'];
        $tipo_proveedor = $_POST['tipo_proveedor'];
        
        //actualizar los datos en la base de datos
        $sql = "UPDATE proveedores SET nombre='$nombre', tipo_proveedor='$tipo_proveedor' WHERE id=$id";
        $result = $conn->query($sql);
        
        //procesar el nuevo archivo subido si se proporciono
        if ($_FILES['archivo']['name']) {
            $archivo_temp = $_FILES['archivo']['tmp_name'];
            $archivo_nombre = "imagen_" . $id . '.jpg';
            $carpeta_destino = 'archivos_subidos/';

            //eliminar el archivo actual
            $sql_archivo_actual = "SELECT archivo_nombre FROM proveedores WHERE id=$id";
            $result_archivo_actual = $conn->query($sql_archivo_actual);
            $row_archivo_actual = $result_archivo_actual->fetch_assoc();
            $ruta_archivo_actual = $carpeta_destino . $row_archivo_actual["archivo_nombre"];
            
            //elimina
            if (file_exists($ruta_archivo_actual)) {
                unlink($ruta_archivo_actual);
            }

            //mover el nuevo archivo temporal a la carpeta de destino
            if (move_uploaded_file($archivo_temp, $carpeta_destino . $archivo_nombre)) {
                //actualiza el nombre del archivo en la base de datos
                $sql_archivo_nuevo = "UPDATE proveedores SET archivo_nombre='$archivo_nombre' WHERE id=$id";
                $result_archivo_nuevo = $conn->query($sql_archivo_nuevo);
                
                //mensajes de error por si no se subio ela rchivo
                if (!$result_archivo_nuevo) {
                    echo "Error al actualizar el nombre del archivo en la base de datos: " . $conn->error;
                }
            } else {
                echo "Error al subir el nuevo archivo.";
            }
        }
        
        //volver a la pagina principal
        header("Location: index.php");
    }

    $sql = "SELECT * FROM proveedores WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Proveedor</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <!--crea la tabla para rellenar con datos de sql -->
        <h2>Editar Proveedor</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
            <input type="text" name="tipo_proveedor" value="<?php echo $row['tipo_proveedor']; ?>" required>
            <!-- Mostrar la foto actual -->
            <?php
            if ($row['archivo_nombre']) {
                echo "<p>Archivo Actual:</p>";
                echo "<img src='archivos_subidos/".$row['archivo_nombre']."' alt='Foto Actual'>";
            }
            ?>
            <input type="file" name="archivo">
            
            <!-- Botón de guardar los cambios -->
            <input type="submit" name="submit" value="Guardar Cambios">
        </form>
    </div>
</body>
</html>

