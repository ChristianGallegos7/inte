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
    <title>ADMINISTRACION DE PEDIDOS</title>
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
                        echo '<td><a href="marcar-completado.php?id=' . $row["pedido_id"] . '" class="btn btn-dark ">Marcar Completado<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"/>
                            <path fill="#22c55e" d="M19.495 3.133a1 1 0 0 1 1.352.308l.99 1.51a1 1 0 0 1-.155 1.28l-.003.004l-.014.013l-.057.053l-.225.215a83.86 83.86 0 0 0-3.62 3.736c-2.197 2.416-4.806 5.578-6.562 8.646c-.49.856-1.687 1.04-2.397.301l-6.485-6.738a1 1 0 0 1 .051-1.436l1.96-1.768A1 1 0 0 1 5.6 9.2l3.309 2.481c5.168-5.097 8.1-7.053 10.586-8.548Zm.21 2.216c-2.29 1.432-5.148 3.509-9.998 8.358A1 1 0 0 1 8.4 13.8l-3.342-2.506l-.581.524l5.317 5.526c1.846-3.07 4.387-6.126 6.49-8.438a85.904 85.904 0 0 1 3.425-3.552l-.003-.005Z"/>
                        </g>
                    </svg></a></td>';
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