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
        // Configura el mensaje de error en la variable $mensajeAlerta
        $mensajeAlerta = 'El correo electrónico ingresado no es válido o no es de Gmail.';
        $claseAlerta = 'alert-danger'; // Cambia la clase a alert-danger para alerta roja
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
        //al index
        header('Location: index.php');
        exit; // Asegúrate de que no se ejecute más código después de la redirección
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
            <!-- Agregar un div para mostrar la alerta de correo -->
            <div class="registro-message alert" id="mensajeAlertaCorreo" style="display: none;"></div>
            <!-- Agregar un div para mostrar la alerta de contraseñas -->
            <div class="registro-message alert" id="mensajeAlertaContrasenas" style="display: none;"></div>
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
                    <input type="text" id="phone" name="phone" class="form-control" required maxlength="10">
                    <small>Ingrese solo números (máximo 10 dígitos) y comience con cero.</small>
                </div>

                <!-- JavaScript para permitir solo números, iniciar con cero y evitar secuencias repetitivas -->
                <script>
                    // Obtén el elemento del campo de teléfono
                    var phoneInput = document.getElementById('phone');

                    // Agrega un detector de eventos para el evento 'input'
                    phoneInput.addEventListener('input', function(event) {
                        // Obtén el valor actual del campo
                        var phoneValue = this.value;

                        // Remueve cualquier carácter que no sea un número
                        var numericValue = phoneValue.replace(/\D/g, '');

                        // Limita la longitud a 10 dígitos
                        if (numericValue.length > 10) {
                            numericValue = numericValue.slice(0, 10);
                        }

                        // Verifica si el número es una secuencia repetitiva
                        if (/^0{1}(\d)\1{8}$/.test(numericValue)) {
                            // Es una secuencia repetitiva, muestra un mensaje de error
                            this.setCustomValidity('No ingrese una secuencia repetitiva de números (e.g., 0111111111).');
                        } else {
                            // No es una secuencia repetitiva, elimina el mensaje de error
                            this.setCustomValidity('');
                        }

                        // Actualiza el valor del campo con solo números
                        this.value = numericValue;
                    });
                </script>




                <button type="submit" class="btn btn-primary">Registrarse</button>
                <a href="index.php" class="btn btn-danger mt-3">Cancelar</a>
            </form>
        </div>
    </div>

    <!-- JavaScript para validar el formulario -->
    <script>
        document.getElementById('registroForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe

            // Obtén el valor del correo
            var correo = document.getElementById('email').value;

            // Verifica si el correo es válido y cumple con el patrón
            if (!correo.match(/[a-zA-Z0-9._%+-]+@gmail\.com$/)) {
                // Muestra el mensaje de alerta de correo en rojo
                var mensajeAlertaCorreo = document.getElementById('mensajeAlertaCorreo');
                mensajeAlertaCorreo.innerHTML = 'El correo electrónico ingresado no es válido o no es de Gmail.';
                mensajeAlertaCorreo.className = 'registro-message alert alert-danger';
                mensajeAlertaCorreo.style.display = 'block';
                setTimeout(function() {
                    mensajeAlertaCorreo.style.display = 'none';
                }, 2000);
                return; // Detiene la validación si el correo no es válido
            }

            // Obtén los valores de las contraseñas
            var contrasena = document.getElementById('password').value;
            var confirmarContrasena = document.getElementById('confirm_password').value;

            // Verifica si las contraseñas coinciden
            if (contrasena !== confirmarContrasena) {
                // Muestra el mensaje de alerta de contraseñas en rojo
                var mensajeAlertaContrasenas = document.getElementById('mensajeAlertaContrasenas');
                mensajeAlertaContrasenas.innerHTML = 'Las contraseñas no coinciden. Inténtalo de nuevo.';
                mensajeAlertaContrasenas.className = 'registro-message alert alert-danger';
                mensajeAlertaContrasenas.style.display = 'block';
                setTimeout(function() {
                    mensajeAlertaContrasenas.style.display = 'none';
                }, 2000);
            } else {
                // Envía el formulario si las contraseñas coinciden
                this.submit();
            }
        });
    </script>

</body>

</html>