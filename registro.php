<?php
// Importa el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verifica si se envió el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $nombre = $_POST['firstname'];
    $correo = $_POST['email'];
    $telefono = $_POST['phone'];
    $contrasena = $_POST['password'];
    $confirmarContrasena = $_POST['confirm_password'];

    // Verifica que las contraseñas coincidan
    if ($contrasena !== $confirmarContrasena) {
        echo '<div class="registro-message">Las contraseñas no coinciden. Inténtalo de nuevo.</div>';
    } else {
        // Encripta la contraseña
        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Prepara la sentencia SQL para insertar los datos del cliente
        $stmt = $conn->prepare('INSERT INTO clientes (nombre, email, telefono, password) VALUES (?, ?, ?, ?)');

        // Verifica si la preparación de la sentencia SQL fue exitosa
        if ($stmt === false) {
            die('Error al preparar la sentencia SQL: ' . $conn->error);
        }

        // Vincula los parámetros con los valores del cliente
        $stmt->bind_param('ssss', $nombre, $correo, $telefono, $contrasenaEncriptada);

        // Ejecuta la sentencia SQL con los datos del cliente
        if ($stmt->execute() === false) {
            die('Error al ejecutar la sentencia SQL: ' . $stmt->error);
        }

        echo '<div class="registro-message">Registro realizado con éxito</div>';

        // Redirige al usuario a la página de éxito después de un breve retraso
        echo <<<EOD
        <script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1500);
        </script>
        EOD;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registro</title>
    <link rel="stylesheet" href="reg.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="col-md-4 mx-auto">
            <h2 class="text-center">Registro</h2>

            <form action="registro.php" method="POST" class="card p-4">
                <div class="mb-3">
                    <label for="firstname" class="form-label">Nombre:</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Registrarse</button>
                <a href="index.php" class="btn btn-danger mt-3">Cancelar</a>
            </form>

        </div>
    </div>
</body>

</html>