<?php
include 'conexion.php';

// crear el proveedor
if (isset($_POST['submit'])) {
    //$id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $tipo_proveedor = $_POST['tipo_proveedor'];
    
        //insertal los datos en la bd
        $sql = "INSERT INTO proveedores (nombre, tipo_proveedor, archivo_nombre) VALUES ('$nombre', '$tipo_proveedor', '$archivo_nombre')";
        //echo $sql;
        $result = $conn->query($sql);

        //obtener el ultimo id ingresado
        $sql1 = "SELECT MAX(id) AS max_id FROM proveedores";
        $result1 = $conn->query($sql1);

        //asocial el ultimo id ingresado a la variable "id_Actual"
        if ($result1) {
           $row1 = $result1->fetch_assoc();
           $id_actual = $row1["max_id"];

           //procesar el archivo subido
           $archivo_temp = $_FILES['archivo']['tmp_name'];
           $archivo_nombre = "imagen_" . $id_actual . '.jpg';
           //carpeta dnde se guardaran los archivos subidos
           $carpeta_destino = 'archivos_subidos/';

           // mover el archivo temporal a la carpeta de destino
           if (move_uploaded_file($archivo_temp, $carpeta_destino . $archivo_nombre)) {

               //actualizar el nombre del archivo
               $sql2 = "UPDATE proveedores SET archivo_nombre='$archivo_nombre' WHERE id='$id_actual'";
               $result2 = $conn->query($sql2);
               //volver a la pagina principal
               //echo "<script>location.href='index.php?llave=2&id=$id';</script>";
               header("Location: index.php");
            } else {
            echo "Error al subir el archivo.";
        }
    }
}
?>
<!--interfaz y muestra de proveedores en pantalla -->
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Proveedores</title>
    <!-- vincular para tomar el estilo de "style.css" y especificar el tipo de contenido de "style.css" -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">

        <!--crea la tabla para rellenar con datos de sql -->

        <h2>Lista de Proveedores</h2>
        <!-- Agregue el atributo "enctype" para permitir subir archivos -->
        <form method="post" enctype="multipart/form-data">
            <!--<input type="text" name="id" placeholder="ID proveedor" required>-->
            <input type="text" name="nombre" placeholder="Nombre del proveedor" required>
            <input type="text" name="tipo_proveedor" placeholder="Tipo de proveedor" required>
            <!-- Campo para subir el archivo -->
            <input type="file" name="archivo">
            <!--boton de agregar los proveedores -->
            <input type="submit" name="submit" value="Agregar Proveedor">
        </form>
        <br>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Archivo</th>
                <th>Tipo de Proveedor</th>
                <th>Acciones</th>
            </tr>
            <?php
            //consume los datos de sql para mostrarlos en la tabla anteriormente creada
            $sql = "SELECT * FROM proveedores";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['nombre']."</td>";
                    //utilizando javascript para al momento de seleccionar ver, se abra una pestaña emergente y muestre el archivo
                    //echo "<td><a href='javascript:void(0);' onclick=\"window.open('archivos_subidos/".$row['archivo_nombre']."', '_blank', 'width=800,height=600');\">ver</a></td>";
                    //abrir la pestaña ver en una pestaña emergente
                    //echo "<td><a href='ver.php?id=".$row['id']."' target='_blank'>Ver</a></td>";
                    echo "<td><a href='ver.php?id=".$row['id']."' onclick=\"window.open(this.href, '_blank', 'width=800,height=600'); return false;\">Ver</a></td>";
                    echo "<td>".$row['tipo_proveedor']."</td>";
                    //muestra de botones editar y borrar en la pantalla
                    echo "<td>
                            <a href='editar.php?id=".$row['id']."'>Editar</a>
                            <a href='borrar.php?id=".$row['id']."'>Borrar</a>
                          </td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
</body>
</html>
