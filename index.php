<?php
session_start();
require_once("conexion.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/index.css">
</head>

<style>

</style>

<body>

    <style>
        .tarjeta {
            background-color: rgba(0, 0, 0, 0.7);
            /* Ajusta el último valor (alfa) para controlar la transparencia */
            /* Otros estilos para la tarjeta */
        }

        .avatar {
            background-color: white;
            width: 30px;
        }

        body {
            height: 100vh;
            background-image: url('images/main.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        #passwordAlerts {
            margin-top: 5px;
            /* Espacio entre el campo de contraseña y las alertas */
        }

        /* Estilos adicionales para las alertas */
        .alerta {
            margin-top: 5px;
            /* Espacio entre las alertas */
        }
    </style>

    <main class="py-5">
        <div class="container container2 d-flex flex-column align-items-center justify-content-center">
            <h2 class="text-center text-white tarjeta p-3">BIENVENIDO A FOODies
                <img src="images/hamburguesa.png" alt="Logo" height="50px">

            </h2>


            <div class="tarjeta p-4 text-white" style="min-width: 450px;">
                <h2 class="text-center">Iniciar sesión</h2>
                <form method="POST" action="index.php">
                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <div class="d-flex align-items-center">
                            <input type="email" class="form-control mb-3" name="email" id="username" required>
                            <img src="./images/avatar.png" alt="avatar" class="avatar mb-3 mx-2" width="30px">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña:</label>
                        <div class="d-flex align-items-center">
                            <input type="password" class="form-control mb-3" id="password" name="password" required>
                            <img src="./images/lock.png" id="showPasswordBtn" alt="avatar" class="avatar mb-3 mx-2" width="30px">
                        </div>
                        <!-- Contenedor para las alertas -->
                        <div id="passwordAlerts">
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
                                $email = $_POST["email"];
                                $password = $_POST["password"];

                                // Consulta la base de datos para verificar las credenciales del usuario
                                $sql = "SELECT * FROM Empleados WHERE email = '$email' AND rol = 'admin'";
                                $result = $conn->query($sql);

                                if ($result->num_rows == 1) {
                                    $row = $result->fetch_assoc();
                                    $hashed_password = $row["password"];

                                    // Verifica la contraseña
                                    if (password_verify($password, $hashed_password)) {
                                        // Inicio de sesión exitoso como administrador, establece las variables de sesión
                                        $_SESSION["cliente_id"] = $row["empleado_id"];
                                        $_SESSION["rol"] = "admin";

                                        // Redirigir al panel de administración
                                        header("Location: admin/index.php");
                                        exit;
                                    } else {
                                        echo '<div class="alert alert-danger d-none alerta" id="adminAlert">
                                                Contraseña incorrecta
                                            </div>';
                                    }
                                } else {
                                    // Si no se encuentra un administrador, verifica el inicio de sesión del cliente
                                    $sql = "SELECT * FROM Clientes WHERE email = '$email'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows == 1) {
                                        $row = $result->fetch_assoc();
                                        if (password_verify($password, $row["password"])) {
                                            // Inicio de sesión exitoso para el cliente, establece las variables de sesión
                                            $_SESSION["cliente_id"] = $row["cliente_id"];
                                            header("Location: secciones/local.php"); // Redirige al usuario a la página principal del cliente
                                            exit;
                                        } else {
                                            echo '<div class="alert alert-danger d-none alerta" id="clientAlert">
                                                Datos incorrectos usuario              
                                            </div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger d-none alerta" id="notFoundAlert">
                                                Usuario no encontrado
                                            </div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>


                    <br>
                    <input type="submit" class="btn btn-primary btn-block" name="login" value="Iniciar Sesión">
                </form>
                <p class="text-center mt-3">¿No tienes una cuenta? <a href="registro.php">Registrarse</a></p>
                <div class="text-center">
                    <strong class="">**Solo disponible en ECUADOR<svg width="30px" height="30px" viewBox="0 0 72 72" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#fcea2b" d="M5 17h62v38H5z" />
                            <path fill="#d22f27" d="M5 45h62v10H5z" />
                            <path fill="#1e50a0" d="M5 36h62v9H5z" />
                            <ellipse cx="36" cy="36" fill="#92d3f5" rx="4.5" ry="6" />
                            <path fill="#5c9e31" d="M40.5 36c0 3.314-2.015 6-4.5 6s-4.5-2.686-4.5-6Z" />
                            <path fill="none" stroke="#d22f27" stroke-miterlimit="10" stroke-width="2" d="M36 46v-4" />
                            <path fill="none" stroke="#f1b31c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M42.065 42a10.928 10.928 0 0 0 2.435-7v-5H46m-20 0h1.5v5a10.928 10.928 0 0 0 2.435 7" />
                            <path fill="none" stroke="#6a462f" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M29 26c3.5-1 5.25 0 7 3c1.75-3 3.5-4 7-3" />
                            <ellipse cx="36" cy="36" fill="none" stroke="#d22f27" stroke-miterlimit="10" stroke-width="2" rx="4.5" ry="6" />
                            <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17h62v38H5z" />
                        </svg>**
                    </strong>
                </div>

            </div>
        </div>
    </main>


    <script>
        const showPasswordBtn = document.getElementById("showPasswordBtn");
        const passwordInput = document.getElementById("password");
        const passwordAlerts = document.getElementById("passwordAlerts"); // Contenedor de alertas

        // Función para mostrar la alerta
        function mostrarAlerta(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove("d-none");
            }
        }

        // Función para ocultar la alerta después de 2 segundos
        function ocultarAlerta(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                setTimeout(function() {
                    alert.classList.add("d-none");
                }, 2000);
            }
        }

        showPasswordBtn.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordBtn.textContent = "Ocultar";
            } else {
                passwordInput.type = "password";
                showPasswordBtn.textContent = "Mostrar";
            }
        });

        // Llama a la función para ocultar las alertas después de 2 segundos
        mostrarAlerta("adminAlert");
        ocultarAlerta("adminAlert");

        // Llama a la función para ocultar las alertas después de 2 segundos
        mostrarAlerta("clientAlert");
        ocultarAlerta("clientAlert");
    </script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>