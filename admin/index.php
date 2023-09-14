<!doctype html>
<html lang="en">

<head>
    <title>DASHBOARD ADMIN</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <header>
        <!-- place navbar here -->
        <!-- <div class="container"> -->
        <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between p-4 mx-3">
            <div>
                <img src="../images/avatar.png" alt="" width="50px">
            </div>
            <div class="nav navbar-nav gap-4">
                <a class="nav-item nav-link btn btn-info p-3" href="#">Admin</a>
                <a class="nav-item nav-link active btn btn-success text-white p-3" href="./productos/crear.php" aria-current="page">Agregar Productos <span class="visually-hidden">(current)</span></a>
                <a class="nav-item nav-link active btn btn-dark text-white p-3" href="./empleados/index.php" aria-current="page">Empleados <span class="visually-hidden">(current)</span></a>
                <a class="nav-item nav-link active btn btn-warning text-white p-3" href="./pedidos/index.php" aria-current="page">Pedidos✅ <span class="visually-hidden">(current)</span></a>
                <!-- <a class="nav-item nav-link active btn btn-warning text-white p-3" href="./locales/crear.php" aria-current="page">Agregar Locales <span class="visually-hidden">(current)</span></a> -->
                <!-- <a class="nav-item nav-link active btn btn-info text-white p-3" href="./locales/index.php" aria-current="page"> Lista Locales <span class="visually-hidden">(current)</span></a> -->
                <a class="nav-item nav-link btn btn-danger text-white mx-3 p-3" href="http://localhost/dashboard/inte/">Salir</a>
            </div>
        </nav>
        <!-- </div> -->
    </header>
    <main>
        <div class="table-responsive">
            <div class="container">
                <h2 class="text-center mt-3">Lista de productos</h2>
                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr>
                            <!-- <th scope="col">ID PRODUCTO</th> -->
                            <th scope="col">NOMBRE PRODUCTO</th>
                            <th scope="col">DESCRIPCION PRODUCTO</th>
                            <!-- <th scope="col">STOCK</th> -->
                            <th scope="col">PRECIO</th>
                            <th scope="col">LOCAL</th>
                            <th scope="col">IMAGEN</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("../conexion.php");

                        $query = "SELECT p.*, l.Nombre AS local_nombre
                        FROM menu p
                        INNER JOIN local l ON p.local_id = l.id_local";

                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row["nombre"] . '</td>';
                            echo '<td>' . $row["descripcion"] . '</td>';
                            echo '<td>' . $row["precio"] . "$" . '</td>';
                            echo '<td class="text-center">' . $row["local_nombre"] . '</td>';
                            $imagen_base64 = base64_encode($row["imagen"]);
                            echo '<td><img width="100px" class="imagenadmin" src="data:image/jpeg;base64,' . $imagen_base64 . '"/></td>';
                            echo '<td>';

                            // Formulario para eliminar el producto
                            echo '<form action="productos/eliminar_producto.php" method="POST" class="d-inline">';
                            echo '<input type="hidden" name="plato_id" value="' . $row["plato_id"] . '">';

                            echo '</form>';
                            echo '<button type="button" class="btn btn-danger m-3 eliminarProducto" data-bs-toggle="modal" data-bs-target="#confirmarEliminacion" data-id-producto="' . $row["plato_id"] . '">Eliminar</button>';

                            // Enlace para editar el producto
                            echo '<a href="productos/editar_producto.php?plato_id=' . $row["plato_id"] . '" class="btn btn-primary">Editar</a>';

                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>




                    </tbody>
                </table>
            </div>
            <!-- Modal para confirmar eliminación -->
            <div class="modal fade" id="confirmarEliminacion" tabindex="-1" aria-labelledby="confirmarEliminacionLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmarEliminacionLabel">Confirmar eliminación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas eliminar este producto?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="eliminarProducto">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Agrega este script al final del archivo -->


    <!-- Bootstrap JavaScript Libraries -->
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let plato_id; // Variable para almacenar el plato_id

            // Detectar evento click del botón "Eliminar"
            document.querySelectorAll('.eliminarProducto').forEach(item => {
                item.addEventListener('click', event => {
                    // Obtener el plato_id del botón clickeado
                    plato_id = event.target.getAttribute('data-id-producto');
                });
            });

            // Detectar evento click del botón "Eliminar" en el modal
            document.querySelector('#eliminarProducto').addEventListener('click', () => {
                // Enviar petición AJAX para eliminar el producto
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'productos/eliminar_producto.php');
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // alert(xhr.responseText);
                        location.reload(); // Recargar la página después de eliminar el producto
                    } else {
                        alert('Error al eliminar el producto');
                    }
                };
                xhr.send(`plato_id=${plato_id}`);

                // Cerrar el modal de confirmación
                const modal = document.querySelector('#confirmarEliminacion');
                const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
            });
        });
    </script>

</body>

</html>