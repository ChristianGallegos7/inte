<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,600&family=Playfair+Display:ital,wght@0,400;0,500;0,700;0,800;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/local.css">
    <style>
        #body {
            font-family: 'Nunito', sans-serif;
            font-family: 'Playfair Display', serif;
            background-image: url('../images/slider-green-deco.jpg');
        }

        .navbar {
            background-color: white;
        }
    </style>
</head>



<body class="d-flex flex-column min-vh-100" id="body">
    <header>
        <nav class="navbar navbar-expand-lg p-2">
            <div class="container-fluid">
                <!-- Elementos a la izquierda -->
                <div class="navbar-nav me-auto">
                    <a class="navbar-brand mx-auto" href="#">
                        <!-- <img src="../images/hamburguesa.png" alt="Logo" height="50px"> -->
                    </a>
                    <div class="d-flex align-items-center justify-content-center mx-auto">
                        <a href="carrito.php" class="nav-link carrito"> <svg width="48" height="48" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="176" cy="416" r="32" fill="#ef4444" />
                                <circle cx="400" cy="416" r="32" fill="#ef4444" />
                                <path fill="#ef4444" d="M167.78 304h261.34l38.4-192H133.89l-8.47-48H32v32h66.58l48 272H432v-32H173.42l-5.64-32z" />
                            </svg> </a>
                    </div>
                </div>
                <!-- Logo en el centro -->

                <h1 class="d-inline-block titulo">FOODies🍜</h1>
                <!-- Elementos a la derecha -->
                <div class="navbar-nav ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Opciones
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="../index.php">Cerrar Sesion🔙</a></li>
                            <!-- <li><a class="dropdown-item" href="#">Elemento 5</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

    </header>
    <main>
        <div class="container my-5 text-center">
            <h2 class="mb-5 text-white">Elige tu local</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">


                <?php
                session_start();
                require("../conexion.php");
                $sql = "SELECT * FROM local";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col">';
                    echo '<div class="card h-100 p-3">';
                    echo '<img class="card-img-top " height="300px" src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '" alt="Imagen del producto">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['Nombre'] . '</h5>';
                    echo '<p class="card-text">Disfrute!</p>';
                    // Aquí generamos el enlace dinámicamente utilizando el nombre del archivo .php
                    $localPage = strtolower(str_replace(" ", "-", $row['Nombre'])) . ".php";
                    echo '<a href="' . $localPage . '" class="btn btn-dark p-3">Ir a este local 🛒</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                // if (isset($_SESSION['carrito'])) {
                //     unset($_SESSION['carrito']); // Elimina el carrito
                // }
                // session_destroy();

                ?>

            </div>
        </div>
    </main>

    <footer class="mt-auto bg-light">
        <!-- place footer here -->
        <div class="container py-3 text-center">
            © FOODies🍜 2023
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>