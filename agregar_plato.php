<?php
session_start();
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_plato"])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    // Aquí puedes procesar la imagen si lo deseas

    $sql = "INSERT INTO Menu (nombre, descripcion, precio) VALUES ('$nombre', '$descripcion', '$precio')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php"); // Redirigir a la página de administración después de agregar el plato
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Agregar Nuevo Plato</h2>
<form method="POST" action="agregar_plato.php">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <br>
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion"></textarea>
    <br>
    <label for="precio">Precio:</label>
    <input type="text" name="precio" required>
    <br>
    <label for="imagen">Imagen:</label>
    <input type="file" name="imagen">
    <br>
    <input type="submit" name="agregar_plato" value="Agregar Plato">
</form>