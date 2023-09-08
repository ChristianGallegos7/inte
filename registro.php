<style>
    .registro-message {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background-color: #008f39;
        color: white;
        text-align: center;
        padding: 10px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        font-weight: bold;
    }

    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: none;
        background-color: #F5F5F5;
        color: #333;
        border-radius: 3px;
    }

    option {
        color: #333;
    }

    /* Estilos adicionales para hacerlo más colorido */

    label {
        font-size: 18px;
    }

    select {
        font-size: 16px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    option:hover {
        background-color: #FFA500;
        color: #fff;
    }

    option:checked {
        background-color: #FFA500;
        color: #fff;
    }

    .cancelar {
        border: red 2px solid;
        padding: 7px;
        background-color: red;
        color: white;
        text-decoration: none;
    }

    .reg {
        margin-bottom: 10px;
    }
</style>
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
</head>

<body>
    <div class="container">
        <h2>Registro</h2>

        <form action="registro.php" method="POST">
            <label for="firstname">Nombre:</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirmar contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="phone">Teléfono:</label>
            <input type="text" id="phone" name="phone" required>

            <input type="submit" value="Registrarse" class="reg">
            <a name="" id="" class="cancelar" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</body>

</html>