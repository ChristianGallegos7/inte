<?php
session_start();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    // Redirige o muestra un mensaje de que el carrito está vacío
    header('Location: pagina-carrito-vacia.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inte";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    $fechaPedido = date("Y-m-d H:i:s");
    $clienteId = 1; // Ajusta el ID del cliente según tu sistema
    $totalPedido = 0;

    $conn->begin_transaction();

    $stmt = $conn->prepare("INSERT INTO Pedidos (cliente_id, fecha_pedido, estado, total) VALUES (?, ?, ?, ?)");
    $estado = "En proceso"; // Puedes ajustar el estado del pedido según tu lógica
    $stmt->bind_param("isss", $clienteId, $fechaPedido, $estado, $totalPedido);
    $stmt->execute();

    $pedidoId = $conn->insert_id;

    foreach ($_SESSION['carrito'] as $producto) {
        $productoId = $producto['id_producto'];
        $cantidad = $producto['cantidad'];
        $precio = $producto['precio'];
        $subtotal = $cantidad * $precio;
        $totalPedido += $subtotal;

        $stmt = $conn->prepare("INSERT INTO Detalles_Pedido (pedido_id, plato_id, cantidad) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $pedidoId, $productoId, $cantidad);
        $stmt->execute();
    }

    $stmt = $conn->prepare("UPDATE Pedidos SET total = ? WHERE pedido_id = ?");
    $stmt->bind_param("di", $totalPedido, $pedidoId);
    $stmt->execute();

    $conn->commit();

    // unset($_SESSION['carrito']);

    echo "<h1>Factura de compra</h1>";
    echo "<p>ID del pedido: $pedidoId</p>";
    echo "<p>Fecha del pedido: $fechaPedido</p>";
    echo "<p>Cliente: Cliente de ejemplo</p>";
    echo "<table border='1'>";
    echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>";

    foreach ($_SESSION['carrito'] as $producto) {
        echo "<tr>";
        echo "<td>{$producto['nombre_producto']}</td>";
        echo "<td>{$producto['cantidad']}</td>";
        echo "<td>{$producto['precio']}</td>";
        echo "<td>" . ($producto['cantidad'] * $producto['precio']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<p>Total a pagar: $totalPedido</p>";
} else {
    echo "<p>El carrito está vacío.</p>";
}

$conn->close();
