<?php
include '../../conexion.php';

if (isset($_GET["id"])) {
    $id_empleado = $_GET["id"];
    
    // Elimina el empleado de la tabla Empleados
    $sql = "DELETE FROM Empleados WHERE empleado_id = '$id_empleado'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirige a la página de administración después de eliminar el empleado
        exit;
    } else {
        echo "Error al eliminar el empleado: " . $conn->error;
    }
} else {
    echo "Empleado no especificado para eliminar.";
}
