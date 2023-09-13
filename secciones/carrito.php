<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light  p-3">
            <div class="container-fluid">
                <h1><a class="navbar-brand titulo" href="#">CARRITO</a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="d-flex align-items-center justify-content-center mx-auto">
                    <a href="carrito.php" class="nav-link carrito"> <img src="../images/carrito.png" alt="CARRITO DE COMPRAS" width="30px" title="Click para ver carrito de compras"> </a>
                </div>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">

                        <!-- <li class="nav-item">
                            <a class="nav-link titulo2" aria-current="page" href="local.php">Inicio</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link titulo2" href="local.php">Regresar a locales🏪</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <h1 class="text-center">Carrito de compras</h1>
            <table class="table">
                <thead>

                </thead>
                <tbody id="cart-items">
                    <?php
                    // session_start();
                    // var_dump($_SESSION['carrito']); // Muestra el contenido del carrito

                    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
                        echo "<p>El carrito está vacío.</p>";
                    } else {
                        echo '<tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                        </tr>';
                        // var_dump($_SESSION['carrito']);

                        foreach ($_SESSION['carrito'] as $key => $producto) {
                            $subtotal = $producto['cantidad'] * $producto['precio'];
                            echo "<tr>
                                    <td>{$producto['nombre_producto']}</td>
                                    <td>
                                        <button class='btn btn-sm btn-success' onclick='aumentarCantidad($key)'>+</button>
                                        <span id='quantity-$key'>{$producto['cantidad']}</span>

                                        <button class='btn btn-sm btn-danger' onclick='disminuirCantidad($key)'>-</button>
                                    </td>
                                    <td>$" . number_format($producto['precio'], 2) . "</td>
                                    <td>$" . number_format($subtotal, 2) . "</td>
                                    <td>
                                        <button class='btn btn-danger' onclick='eliminarProducto($key)' data-product-id='$key'>Eliminar</button>
                                    </td>

                                </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

            <!-- <div class="d-flex justify-content-end">
                <h4> Total: $<span id="cart-total"><?php echo number_format($total, 2); ?></span></h4>
            </div> -->
            <div class="fixed-bottom bg-light p-3">
                <div class="container">
                    <div class="">
                        <a name="pagar" id="pagar" class="btn btn-primary" href="generar-factura.php" role="button">PAGAR</a>

                        <a name="pagar" id="comprar" class="btn btn-primary" href="local.php" role="button">SEGUIR COMPRANDO</a>
                        <button class="btn btn-danger" id="vaciar-carrito">Vaciar Carrito</button>
                    </div>
                </div>
            </div>


        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <script>
        function disminuirCantidad(productId) {
            // Obtén la cantidad actual del producto
            const quantitySpan = document.querySelector(`#quantity-${productId}`);
            let currentQuantity = parseInt(quantitySpan.textContent);

            // Asegúrate de que la cantidad no sea menor que 0
            if (currentQuantity > 0) {
                // Realiza una solicitud AJAX para actualizar la cantidad en el servidor
                fetch('actualizar-carrito.php', {
                        method: "POST",
                        body: JSON.stringify({
                            productId,
                            action: 'decrease'
                        }), // Envía el ID del producto y la acción
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Actualiza la cantidad en la tabla
                        currentQuantity--; // Disminuye la cantidad en 1
                        quantitySpan.textContent = currentQuantity;

                        // Agrega console.log para verificar los valores
                        console.log('Valor del subtotal recibido:', data.subtotal);

                        // Actualiza el subtotal en el frontend con el nuevo valor del servidor
                        const subtotalSpan = $(`#subtotal-${productId}`);
                        subtotalSpan.text('$' + data.subtotal.toFixed(2));

                        // También puedes actualizar el total aquí si es necesario
                        const totalSpan = $('#cart-total');
                        totalSpan.text('$' + data.total.toFixed(2));
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            }
        }



        function aumentarCantidad(productId) {
            // Realiza una solicitud AJAX para actualizar la cantidad en el servidor con jQuery
            $.ajax({
                url: 'actualizar-carrito.php',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify({
                    productId: productId,
                    action: 'increase'
                }),
                contentType: 'application/json',
                success: function(data) {
                    // Actualiza la cantidad en la tabla
                    const quantitySpan = $(`#quantity-${productId}`);
                    const newQuantity = parseInt(quantitySpan.text()) + 1;
                    quantitySpan.text(newQuantity);

                    // Actualiza el subtotal en el frontend con el nuevo valor del servidor
                    const subtotalSpan = $(`#subtotal-${productId}`);
                    subtotalSpan.text('$' + data.subtotal.toFixed(2));

                    // Actualiza el total en el frontend
                    const totalSpan = $('#cart-total');
                    totalSpan.text('$' + data.total.toFixed(2));
                },
                error: function(error) {
                    console.error("Error:", error);
                }
            });
        }



        function eliminarProducto(productId) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
                $.ajax({
                    url: 'eliminar-producto.php',
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        productId,
                    }),
                    contentType: 'application/json',
                    success: function(data) {
                        if (data.result === 'success') {
                            alert('El producto ha sido eliminado del carrito.');
                            // Resto del código para eliminar la fila del producto
                        } else {
                            alert('Error al eliminar el producto del carrito.');
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                        alert('Error al eliminar el producto del carrito gil de mierda.');
                    }
                });
            }
        }



        document.addEventListener("DOMContentLoaded", function() {
            const vaciarCarritoButton = document.getElementById('vaciar-carrito');
            const cartItemsTableBody = document.getElementById('cart-items');
            const pagarButton = document.getElementById('pagar'); // Agrega esta línea

            // Función para habilitar o deshabilitar el botón "PAGAR"
            function actualizarEstadoPagarButton() {
                if (cartItemsTableBody.children.length > 0) {
                    pagarButton.classList.remove('disabled'); // Habilitar el botón
                } else {
                    pagarButton.classList.add('disabled'); // Deshabilitar el botón
                }
            }

            // Verificar el estado del carrito al cargar la página
            actualizarEstadoPagarButton();

            vaciarCarritoButton.addEventListener('click', function() {
                if (confirm('¿Estás seguro de que deseas vaciar el carrito?')) {
                    // Vaciar el carrito en el servidor (puedes hacerlo mediante una solicitud AJAX)

                    // Limpiar la tabla de productos en el carrito
                    while (cartItemsTableBody.firstChild) {
                        cartItemsTableBody.removeChild(cartItemsTableBody.firstChild);
                    }

                    // Actualizar el carrito en la sesión (eliminando todos los productos)
                    fetch('vaciar-carrito.php', {
                            method: "POST"
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert('El carrito ha sido vaciado.');
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });

                    // Actualizar el estado del botón "PAGAR" después de vaciar el carrito
                    actualizarEstadoPagarButton();
                }
            });
        });
    </script>


</body>

</html>