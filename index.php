<?php
session_start();
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inicio_sesion"])) {
    // Recupera las credenciales del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Consulta la base de datos para verificar las credenciales
    $sql = "SELECT * FROM Clientes WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Inicio de sesión exitoso
            $_SESSION["cliente_id"] = $row["cliente_id"];
            header("Location: main.php"); // Redirige al usuario a la página principal
            exit;
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
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
        <input type="submit" name="inicio_sesion" value="Iniciar Sesión">
    </form>
    <a href="registro.php">Crear cuenta</a>
</body>
</html>
