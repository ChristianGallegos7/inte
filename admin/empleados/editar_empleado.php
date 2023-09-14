<?php
include '../../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_empleado"])) {
    $id_empleado = $_POST["id_empleado"];
    $nombre_empleado = $_POST["nombre_empleado"];
    $email_empleado = $_POST["email_empleado"];
    $rol_empleado = $_POST["rol_empleado"];
    $local_empleado = $_POST["local_empleado"];

    // Actualiza los datos del empleado en la tabla Empleados
    $sql = "UPDATE Empleados SET nombre = '$nombre_empleado', email = '$email_empleado', rol = '$rol_empleado', local_id = '$local_empleado' WHERE empleado_id = '$id_empleado'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirige a la página de administración después de editar el empleado
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtén los datos del empleado para prellenar el formulario de edición
if (isset($_GET["id"])) {
    $id_empleado = $_GET["id"];
    $sql = "SELECT * FROM Empleados WHERE empleado_id = '$id_empleado'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_empleado = $row["nombre"];
        $email_empleado = $row["email"];
        $rol_empleado = $row["rol"];
        $local_empleado = $row["local_id"];
    } else {
        echo "Empleado no encontrado.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Editar Empleado</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <header>
        <!-- Navbar here -->
    </header>
    <main class="container mt-4">
        <h2 class="mb-4">Editar Empleado</h2>
        <form method="POST" action="editar_empleado.php">
            <input type="hidden" name="id_empleado" value="<?php echo $id_empleado; ?>">
            <div class="mb-3">
                <label for="nombre_empleado" class="form-label">Nombre:</label>
                <input type="text" name="nombre_empleado" class="form-control" value="<?php echo $nombre_empleado; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email_empleado" class="form-label">Correo Electrónico:</label>
                <input type="email" name="email_empleado" class="form-control" value="<?php echo $email_empleado; ?>" required>
            </div>
            <div class="mb-3">
                <label for="rol_empleado" class="form-label">Rol:</label>
                <input type="text" name="rol_empleado" class="form-control" value="<?php echo $rol_empleado; ?>" required>
            </div>
            <div class="mb-3">
                <label for="local_empleado" class="form-label">Local:</label>
                <select name="local_empleado" class="form-select" required>
                    <option value="">Seleccionar Local</option>
                    <?php
                    // Consulta para obtener la lista de locales
                    $queryLocales = "SELECT id_local, Nombre FROM Local";
                    $resultLocales = mysqli_query($conn, $queryLocales);

                    // Genera opciones para cada local
                    while ($rowLocal = mysqli_fetch_assoc($resultLocales)) {
                        $selected = ($rowLocal["id_local"] == $local_empleado) ? 'selected' : '';
                        echo '<option value="' . $rowLocal["id_local"] . '" ' . $selected . '>' . $rowLocal["Nombre"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="editar_empleado" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php" name="cancelar" class="btn btn-primary">Cancelar</a>

        </form>
    </main>

    <footer>
        <!-- Footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>