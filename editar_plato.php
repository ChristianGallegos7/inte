<?php
session_start();
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $plato_id = $_GET["id"];
    // Consulta la base de datos para obtener la información del plato
    $sql = "SELECT * FROM Menu WHERE plato_id = '$plato_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre = $row["nombre"];
        $descripcion = $row["descripcion"];
        $precio = $row["precio"];
    } else {
        echo "Plato no encontrado.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_plato"])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    // Aquí puedes procesar la imagen si lo deseas

    $sql = "UPDATE Menu SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio' WHERE plato_id = '$plato_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php"); // Redirigir a la página de administración después de editar el plato
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Plato</title>
</head>

<body>
    <h1>Editar Plato</h1>

    <?php
    session_start();
    include 'conexion.php'; // Incluir el archivo de conexión

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $plato_id = $_GET["id"];
        // Consulta la base de datos para obtener la información del plato
        $sql = "SELECT * FROM Menu WHERE plato_id = '$plato_id'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $nombre = $row["nombre"];
            $descripcion = $row["descripcion"];
            $precio = $row["precio"];
        } else {
            echo "Plato no encontrado.";
            exit;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_plato"])) {
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $precio = $_POST["precio"];
        // Aquí puedes procesar la imagen si lo deseas

        $sql = "UPDATE Menu SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio' WHERE plato_id = '$plato_id'";

        if ($conn->query($sql) === TRUE) {
            header("Location: admin.php"); // Redirigir a la página de administración después de editar el plato
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <!-- Formulario de Edición -->
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion"><?php echo $descripcion; ?></textarea>
        <br>
        <label for="precio">Precio:</label>
        <input type="text" name="precio" value="<?php echo $precio; ?>" required>
        <br>
        <!-- Puedes agregar aquí campos para procesar la imagen si es necesario -->
        <br>
        <input type="submit" name="editar_plato" value="Guardar Cambios">
    </form>
</body>

</html>