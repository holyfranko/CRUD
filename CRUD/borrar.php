<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //obtener el nombre del archivo antes de borrar el registro
    $sql_archivo = "SELECT archivo_nombre FROM proveedores WHERE id=$id";
    $result_archivo = $conn->query($sql_archivo);
    $row_archivo = $result_archivo->fetch_assoc();
    $archivo_a_borrar = $row_archivo["archivo_nombre"];

    //eliminar el archivo si existe
    $carpeta_destino = 'archivos_subidos/';
    $ruta_archivo_a_borrar = $carpeta_destino . $archivo_a_borrar;

    if (file_exists($ruta_archivo_a_borrar)) {
        unlink($ruta_archivo_a_borrar);
    }

    //borrar el registro de la tabla con el id
    $sql = "DELETE FROM proveedores WHERE id=$id";
    $result = $conn->query($sql);

    //volver a la pagina principal
    header("Location: index.php");
}
?>