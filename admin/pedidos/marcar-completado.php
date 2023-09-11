<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inte";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $pedidoId = $_GET['id'];

    // Actualizar el estado del pedido a "Completado"
    $sql = "UPDATE Pedidos SET estado = 'Completado' WHERE pedido_id = $pedidoId";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php'); // Redirigir de nuevo a la página de administración de pedidos
        exit;
    } else {
        echo "Error al actualizar el estado del pedido: " . $conn->error;
    }
} else {
    echo "ID de pedido no proporcionado.";
}
