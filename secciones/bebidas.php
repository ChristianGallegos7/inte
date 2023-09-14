<!doctype html>
<html lang="en">

<head>
    <title>BEBIDAS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,600&family=Playfair+Display:ital,wght@0,400;0,500;0,700;0,800;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/kfc.css">
</head>

<body id="body">
    <style>
        .carrito {
            margin-left: 50px;
        }

        .container {
            margin-top: 100px;
        }

        #body {
            background-image: url('../images/hielo.avif');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Nunito', sans-serif;
            font-family: 'Playfair Display', serif;
        }

        .card-title {
            font-weight: 900;

            /* Peso de letra en el título */
        }

        .card-description {
            font-weight: bold;
            /* Peso de letra en la descripción */
        }

        .card-price {
            font-weight: bold;
            /* Peso de letra en el precio */
        }
    </style>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light  p-3">
            <div class="container-fluid">
                <h1><a class="navbar-brand titulo" href="#">BEBIDAS</a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="d-flex align-items-center justify-content-center mx-auto">
                    <a href="carrito.php" class="nav-link carrito"> <svg width="48" height="48" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="176" cy="416" r="32" fill="#ffffff" />
                            <circle cx="400" cy="416" r="32" fill="#ffffff" />
                            <path fill="#ffffff" d="M167.78 304h261.34l38.4-192H133.89l-8.47-48H32v32h66.58l48 272H432v-32H173.42l-5.64-32z" />
                        </svg> </a>
                </div>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- <a class="nav-link titulo2" aria-current="page" href="#">Inicio</a> -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link titulo2 card-title" href="local.php">Regresar a locales</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <!-- CARGAR PRODUCTOS DESDE LA TABLA MENU -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            require("../conexion.php");
            $sql = "SELECT * FROM Menu WHERE local_id = 6";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $precio = $row['precio'];
                echo '<div class="col">';
                echo '<div class="card text-center my-3 bg-blue">';
                echo '<img class="card-img-top " height="300px" src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '" alt="Imagen del producto">';
                echo '<h5 class="card-title mx-3 card-title">' . $row['nombre'] . '</h5>';
                echo '<div class="card-body">';
                echo '<p class="card-text card-description">' . $row['descripcion'] . '</p>';
                echo '<p class="card-text card-price">Precio: $' . number_format($precio, 2) . '</p>';

                // FORMULARIO
                echo '<form method="POST">';
                echo '<input type="hidden" name="id_producto" value="' . $row['plato_id'] . '">';
                echo '<input type="number" class="form-control mb-3" name="cantidad[]" value="0" min="0">';
                echo '<input type="hidden" name="precio[]" value="' . $precio . '">';
                echo '<input type="hidden" name="nombre_producto[]" value="' . $row['nombre'] . '">';

                echo '<div class="text-center">';
                echo '<button class="btn btn-primary add-to-cart-btn" data-product-id="' . $row['plato_id'] . '">Añadir al carrito</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

            addToCartButtons.forEach(button => {
                button.addEventListener("click", function() {
                    event.preventDefault();
                    const productId = this.getAttribute('data-product-id');
                    const cantidadInput = this.closest('.card-body').querySelector('input[name="cantidad[]"]');
                    const precioInput = this.closest('.card-body').querySelector('input[name="precio[]"]');
                    const nombreProductoInput = this.closest('.card-body').querySelector('input[name="nombre_producto[]"]');

                    const cantidad = cantidadInput.value;
                    const precio = precioInput.value;
                    const nombre_producto = nombreProductoInput.value;

                    console.log("Datos enviados al servidor:");
                    console.log("Product ID:", productId);
                    console.log("Cantidad:", cantidad);
                    console.log("Precio:", precio);
                    console.log("Nombre del producto:", nombre_producto);

                    // Verificar si la cantidad es mayor que cero antes de agregar al carrito
                    if (parseInt(cantidad) > 0) {
                        const formData = new FormData();
                        formData.append("productId", productId);
                        formData.append("cantidad", cantidad);
                        formData.append("precio", precio);
                        formData.append("nombre_producto", nombre_producto);

                        fetch('add-to-cart.php', {
                                method: "POST",
                                body: formData
                            })
                            .then(response => response.text())
                            .then(data => {
                                alert('Producto agregado al carrito');
                            })
                            .catch(error => {
                                console.error("Error:", error);
                            });
                    } else {
                        alert('Selecciona al menos un producto para agregar al carrito');
                    }
                });
            });
        });
    </script>

</body>

</html>