<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lista de Empleados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <header>
        <!-- place navbar here -->
        <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between p-4 mx-3">
            <div>
                <img src="../../images/avatar.png" alt="" width="50px">
            </div>
            <div class="nav navbar-nav gap-4">
                <a class="nav-item nav-link btn btn-info p-3" href="../index.php">Volver</a>
                <a class="nav-item nav-link active btn btn-success text-white p-3" href="./agregar_empleado.php" aria-current="page">Agregar Empleados <span class="visually-hidden">(current)</span></a>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
        <h2 class="text-center">Lista de Empleados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID EMPLEADO</th>

                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Local</th> <!-- Nueva columna para mostrar el local -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../../conexion.php");
                // Modifica la consulta SQL para obtener el nombre del local al que pertenece cada empleado
                $query = "SELECT e.empleado_id, e.nombre, e.email, e.rol, l.Nombre as nombre_local FROM Empleados e
                INNER JOIN Local l ON e.local_id = l.id_local";

                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['empleado_id'] . '</td>';
                    echo '<td>' . $row['nombre'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['rol'] . '</td>';
                    echo '<td>' . $row['nombre_local'] . '</td>';
                    echo '<td><a href="editar_empleado.php?id=' . $row['empleado_id'] . '" class="btn btn-primary">Editar</a></td>';
                    echo '<td><a href="eliminar_empleado.php?id=' . $row['empleado_id'] . '" class="btn btn-danger">Eliminar</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
</body>

</html>