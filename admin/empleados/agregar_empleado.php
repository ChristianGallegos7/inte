<?php
include '../../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_empleado"])) {
    $nombre_empleado = $_POST["nombre_empleado"];
    $email_empleado = $_POST["email_empleado"];
    $password_empleado = $_POST["password_empleado"];
    $rol_empleado = $_POST["rol_empleado"];
    $local_empleado = $_POST["local_empleado"];

    // Verifica si el correo electrónico del empleado ya está registrado
    $sql = "SELECT * FROM Empleados WHERE email = '$email_empleado'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado para otro empleado.";
    } else {
        // Hash de la contraseña antes de almacenarla en la base de datos
        $hashed_password = password_hash($password_empleado, PASSWORD_DEFAULT);

        // Inserta los datos del nuevo empleado en la tabla Empleados
        $sql = "INSERT INTO Empleados (nombre, email, password, rol, local_id) VALUES ('$nombre_empleado', '$email_empleado', '$hashed_password', '$rol_empleado', '$local_empleado')";

        if ($conn->query($sql) === TRUE) {
            header("Location: ../index.php"); // Redirigir a la página de administración después de agregar el empleado
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Agregar Nuevo Empleado</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main class="container mt-4">
        <h2>Agregar Nuevo Empleado</h2>
        <form method="POST" action="agregar_empleado.php">
            <label for="nombre_empleado">Nombre:</label>
            <input type="text" name="nombre_empleado" required>
            <br>
            <label for="email_empleado">Correo Electrónico:</label>
            <input type="email" name="email_empleado" required>
            <br>
            <label for="password_empleado">Contraseña:</label>
            <input type="password" name="password_empleado" required>
            <br>
            <label for="rol_empleado">Rol:</label>
            <input type="text" name="rol_empleado" required>
            <br>
            <label for="local_empleado">Local:</label>
            <select name="local_empleado" required>
                <option value="">Seleccionar Local</option>
                <?php
                // Consulta para obtener la lista de locales
                $queryLocales = "SELECT id_local, Nombre FROM Local";
                $resultLocales = mysqli_query($conn, $queryLocales);

                // Genera opciones para cada local
                while ($rowLocal = mysqli_fetch_assoc($resultLocales)) {
                    echo '<option value="' . $rowLocal["id_local"] . '">' . $rowLocal["Nombre"] . '</option>';
                }
                ?>
            </select>
            <br>
            <input type="submit" name="agregar_empleado" value="Agregar Empleado">
        </form>
    </main>

    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>