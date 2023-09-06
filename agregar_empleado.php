<?php
session_start();
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_empleado"])) {
    $nombre_empleado = $_POST["nombre_empleado"];
    $email_empleado = $_POST["email_empleado"];
    $rol_empleado = $_POST["rol_empleado"];
    $password_empleado = $_POST["password_empleado"];

    // Verificar si el correo electrónico del empleado ya está registrado
    $sql = "SELECT * FROM Empleados WHERE email = '$email_empleado'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado para otro empleado.";
    } else {
        // Generar el hash de la contraseña
        $hashed_password = password_hash($password_empleado, PASSWORD_BCRYPT);

        // Insertar los datos del nuevo empleado en la tabla Empleados
        $sql = "INSERT INTO Empleados (nombre, email, rol, password) VALUES ('$nombre_empleado', '$email_empleado', '$rol_empleado', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: admin.php"); // Redirigir a la página de administración después de agregar el empleado
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>


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
    <input type="submit" name="agregar_empleado" value="Agregar Empleado">
</form>