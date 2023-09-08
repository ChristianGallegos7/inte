<?php
// Importa el archivo de conexión a la base de datos
require_once 'conexion.php';

// Define las variables para el mensaje de alerta y la clase de alerta
$mensajeAlerta = '';
$claseAlerta = '';

// Verifica si se envió el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $nombre = $_POST['firstname'];
    $correo = $_POST['email'];
    $telefono = $_POST['phone'];
    $contrasena = $_POST['password'];
    $confirmarContrasena = $_POST['confirm_password'];

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail\.com$/", $correo)) {
        // El correo electrónico no tiene un formato válido o no es de Gmail
        // Puedes mostrar un mensaje de error o realizar otras acciones necesarias
        echo '<div class="registro-message alert" id="mensajeAlerta2" style="display: none;"></div>';
    } else {
        // El correo electrónico es válido y es de Gmail, procede con la inserción en la base de datos
        // ...
    }

    // Verifica si el correo electrónico ya está en uso
    $stmt = $conn->prepare('SELECT email FROM clientes WHERE email = ?');
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El correo electrónico ya está en uso, muestra una alerta
        $mensajeAlerta = 'El correo electrónico ya está registrado. Inténtalo con otro.';
        $claseAlerta = 'alert-danger'; // Cambia la clase a alert-danger para alerta roja
    } elseif ($contrasena !== $confirmarContrasena) {
        // Verifica que las contraseñas coincidan
        $mensajeAlerta = 'Las contraseñas no coinciden. Inténtalo de nuevo.';
        $claseAlerta = 'alert-danger'; // Cambia la clase a alert-danger para alerta roja
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

        $mensajeAlerta = 'Registro realizado con éxito';
        $claseAlerta = 'alert-success'; // Cambia la clase a alert-success para alerta verde
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
            <!-- Agregar un div para mostrar la alerta -->
            <div class="registro-message alert" id="mensajeAlerta" style="display: none;"></div>
            <form action="registro.php" method="POST" class="card p-4" id="registroForm">
                <div class="mb-3">
                    <label for="firstname" class="form-label">Nombre:</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico:</label>
                    <input type="email" id="email" name="email" class="form-control" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com">
                    <small>Ingrese una dirección de correo de Gmail válida.</small>
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
                    <input type="text" id="phone" name="phone" class="form-control" required pattern="[0-9]{1,10}">
                    <small>Ingrese solo números (máximo 10 dígitos).</small>
                </div>


                <button type="submit" class="btn btn-primary">Registrarse</button>
                <a href="index.php" class="btn btn-danger mt-3">Cancelar</a>
            </form>


        </div>
    </div>

    <!-- JavaScript para validar el formulario -->
    <script>
        document.getElementById('registroForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe

            // Obtén los valores de las contraseñas
            var contrasena = document.getElementById('password').value;
            var confirmarContrasena = document.getElementById('confirm_password').value;

            // Verifica si las contraseñas coinciden
            if (contrasena !== confirmarContrasena) {
                // Muestra el mensaje de alerta en rojo
                var mensajeAlerta = document.getElementById('mensajeAlerta');
                mensajeAlerta.innerHTML = 'Las contraseñas no coinciden. Inténtalo de nuevo.';
                mensajeAlerta.className = 'registro-message alert alert-danger';
                mensajeAlerta.style.display = 'block';
                setTimeout(function() {
                    mensajeAlerta.style.display = 'none';
                }, 2000);
            } else {
                // Envía el formulario si las contraseñas coinciden
                this.submit();
            }
        });
    </script>
</body>

</html>