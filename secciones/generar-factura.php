<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        /* Estilos para el formulario de tarjeta de crédito */
        .tarjeta-credito {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .tarjeta-credito .front,
        .tarjeta-credito .back {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .tarjeta-credito .front {
            background-color: #007bff;
            color: white;
        }

        .tarjeta-credito .back {
            background-color: #f0f0f0;
            color: #333;
        }

        .tarjeta-credito .chip {
            width: 60px;
            height: 40px;
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .tarjeta-credito .datos {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .tarjeta-credito label {
            font-weight: bold;
        }

        .tarjeta-credito input[type="text"],
        .tarjeta-credito input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .tarjeta-credito .flex {
            display: flex;
            justify-content: space-between;
        }

        .tarjeta-credito button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .tarjeta-credito button:hover {
            background-color: #0056b3;
        }

        /* Ocultar la parte trasera de la tarjeta por defecto */
        .tarjeta-credito .back {
            display: none;
        }

        /* Mostrar la parte trasera de la tarjeta cuando se hace clic en el botón "Pagar con Tarjeta" */
        .tarjeta-credito.mostrar-trasera .back {
            display: block;
        }
    </style>
    <div class="container">
        <h1 class="my-4">Factura de Compra</h1>
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
        }
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Bucle para mostrar productos y detalles
                foreach ($_SESSION['carrito'] as $producto) {
                    echo "<tr>";
                    echo "<td>{$producto['nombre_producto']}</td>";
                    echo "<td>{$producto['cantidad']}</td>";
                    echo "<td>{$producto['precio']}</td>";
                    echo "<td>" . ($producto['cantidad'] * $producto['precio']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <p class="lead">Total a pagar: $<?php echo $totalPedido; ?></p>

        <!-- Botones para seleccionar el método de pago -->
        <h2>Seleccione el método de pago:</h2>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">Efectivo</button>
            <button type="button" class="btn btn-primary">Tarjeta</button>
        </div>

        <!-- Formulario para ingresar detalles de la tarjeta (mostrar/ocultar según la selección) -->
        <div id="tarjeta-form" style="display: none;" class="card p-3 mt-3">
            <h2>Detalles de Tarjeta</h2>
            <form>
                <div class="tarjeta-credito" style="max-width: 39%;" class="p-3">
                    <div class="front">
                        <div class="chip"></div>
                        <div class="datos">
                            <div class="grupo">
                                <label for="nombre-tarjeta">Nombre en la Tarjeta:</label>
                                <input type="text" id="nombre-tarjeta" name="nombre-tarjeta" oninput="mayusNameCard()">
                            </div>
                            <div class="grupo">
                                <label for="numero-tarjeta">Número de Tarjeta:</label>
                                <input type="text" id="numero-tarjeta" name="numero-tarjeta" class="mx-3" required>
                            </div>
                            <div class="flex">
                                <div class="grupo mx-3">
                                    <label for="expiracion">Expiración:</label>
                                    <input type="text" id="expiracion" name="expiracion" placeholder="MM/AA">
                                </div>
                                <div class="grupo">
                                    <label for="cvv">CVV:</label>
                                    <input type="text" id="cvv" name="cvv">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="back">
                        <div class="firm">
                            <label for="firma">Firma:</label>
                            <input type="text" id="firma" name="firma">
                        </div>
                    </div>
                </div>
                <!-- Agrega más campos según tus necesidades -->
                <button type="button" class="btn btn-primary" onclick="mostrarParteTrasera()">Pagar</button>

            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
    <script>
        // Mostrar u ocultar el formulario de tarjeta al hacer clic en el botón "Tarjeta"
        $(".btn-group button").click(function() {
            if ($(this).text() === "Tarjeta") {
                $("#tarjeta-form").show();
            } else {
                $("#tarjeta-form").hide();
            }
        });
    </script>
    <script>
        function mostrarParteTrasera() {
            const tarjetaCredito = document.querySelector('.tarjeta-credito');
            tarjetaCredito.classList.toggle('mostrar-trasera');
        }

        function mayusNameCard() {
            let nombreCard = document.getElementById("nombre-tarjeta");
            nombreCard.value = nombreCard.value.toUpperCase();
        }


        // Función para validar y formatear el número de tarjeta
        function validarNumeroTarjeta() {
            const inputNumeroTarjeta = document.getElementById("numero-tarjeta");
            let numeroTarjeta = inputNumeroTarjeta.value.replace(/\D/g, ''); // Elimina caracteres no numéricos
            numeroTarjeta = numeroTarjeta.slice(0, 16); // Limita a 16 dígitos
            const formattedNumeroTarjeta = formatNumeroTarjeta(numeroTarjeta);
            inputNumeroTarjeta.value = formattedNumeroTarjeta;
        }

        // Función para formatear el número de tarjeta en grupos de 4 dígitos
        function formatNumeroTarjeta(numeroTarjeta) {
            const groups = numeroTarjeta.match(/.{1,4}/g); // Divide el número en grupos de 4 dígitos
            if (groups) {
                return groups.join('-'); // Agrega guiones entre los grupos
            }
            return numeroTarjeta;
        }

        // Agregar un evento para validar el número de tarjeta en cada entrada del usuario
        const inputNumeroTarjeta = document.getElementById("numero-tarjeta");
        inputNumeroTarjeta.addEventListener("input", validarNumeroTarjeta);
    </script>


</body>

</html>