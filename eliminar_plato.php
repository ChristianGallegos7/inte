<?php
session_start();
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $plato_id = $_GET["id"];
    // Consulta la base de datos para eliminar el plato
    $sql = "DELETE FROM Menu WHERE plato_id = '$plato_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php"); // Redirigir a la página de administración después de eliminar el plato
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
