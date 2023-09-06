<?php
session_start();
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registro"])) {
    // Recupera los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $password = $_POST["password"];

    // Verifica si el correo electrónico ya está registrado
    $sql = "SELECT * FROM Clientes WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        // Hashea la contraseña antes de almacenarla en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Inserta los datos del nuevo usuario en la tabla Clientes
        $sql = "INSERT INTO Clientes (nombre, email, telefono, password) VALUES ('$nombre', '$email', '$telefono', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // Registro exitoso, redirigir al usuario a la página de inicio de sesión
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!-- Aquí puedes incluir el formulario HTML -->


<!-- Aquí puedes incluir el formulario HTML -->

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h1>Registro</h1>
    <form method="POST" action="registro.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required>
        <br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="registro" value="Registrarse">
    </form>
</body>
</html>

