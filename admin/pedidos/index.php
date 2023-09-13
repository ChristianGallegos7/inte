<?php
// Conexión a la base de datos y consulta de pedidos pendientes
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inte";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT p.pedido_id, p.fecha_pedido, p.estado, m.imagen AS imagen_producto, m.nombre AS nombre_producto, dp.cantidad
        FROM Pedidos p
        LEFT JOIN Detalles_Pedido dp ON p.pedido_id = dp.pedido_id
        LEFT JOIN Menu m ON dp.plato_id = m.plato_id
        WHERE p.estado = 'En proceso'";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between p-4 mx-3">
        <div>
            <img src="../../images/avatar.png" alt="" width="50px">
        </div>
        <div class="nav navbar-nav gap-4">
            <a class="nav-item nav-link btn btn-info p-3 text-white" href="../index.php">Admin</a>
            <a class="nav-item nav-link btn btn-success p-3 text-white" href="../index.php">Volver</a>
        </div>
    </nav>
    <div class="container">
        <h1 class="my-4">Administración de Pedidos</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID de Pedido</th>
                    <th>Fecha de Pedido</th>
                    <th>Estado</th>
                    <th>Detalles del Producto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["pedido_id"] . "</td>";
                        echo "<td>" . $row["fecha_pedido"] . "</td>";
                        echo "<td>" . $row["estado"] . "</td>";
                        echo "<td>";

                        // Mostrar los detalles de los productos del pedido
                        echo "<ul>";
                        echo "<li>Nombre del Producto: " . $row["nombre_producto"] . "</li>";
                        echo "<li>Cantidad: " . $row["cantidad"] . "</li>";

                        // Mostrar la imagen del producto
                        // Mostrar la imagen del producto
                        echo '<li>Imagen del Producto: <img src="data:image/jpeg;base64,' . base64_encode($row["imagen_producto"]) . '" alt="Imagen del Producto" width="100"></li>';


                        // Puedes agregar más detalles aquí si es necesario
                        echo "</ul>";

                        echo "</td>";
                        echo '<td><a href="marcar-completado.php?id=' . $row["pedido_id"] . '">Marcar Completado</a></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay pedidos pendientes.</td></tr>";
                }


                ?>
            </tbody>
        </table>
    </div>
</body>

</html>