<?php
session_start();
require_once("conexion.php");

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
            header("Location: admin.php");
            exit;
        } else {
            echo "Contraseña incorrecta para el administrador.";
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
                header("Location: main.php"); // Redirige al usuario a la página principal del cliente
                exit;
            } else {
                echo "Contraseña incorrecta para el cliente.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Iniciar Sesión</title>
</head>

<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="index.php">
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="login" value="Iniciar Sesión">
    </form>
    <a href="registro.php">Crear cuenta</a>
</body>

</html>