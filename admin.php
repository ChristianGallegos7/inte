<!DOCTYPE html>
<html>

<head>
    <title>Panel de Administración</title>
</head>

<body>
    <h1>Panel de Administración</h1>
    <!-- Navbar -->
    <ul class="navbar">
        <li><a href="admin.php">Inicio</a></li>
        <li><a href="agregar_plato.php">Agregar Plato</a></li>
        <li><a href="agregar_empleado.php">Agregar Empleado</a></li>
        <!-- Agrega más elementos de menú según sea necesario -->
        <li><a href="index.php">Cerrar Sesión</a></li>
    </ul>
    <?php
    // Verificar el rol del usuario antes de permitir el acceso a esta página
    session_start();
    // if (!isset($_SESSION["cliente_id"]) || $_SESSION["rol"] !== "admin") {
    //     header("Location: login.php"); // Redirigir a la página de inicio de sesión si el usuario no es un administrador
    //     exit;
    // }
    ?>

    <!-- Mostrar la lista de platos del menú -->
    <h2>Platos en el Menú</h2>
    <ul>
        <?php
        require_once("conexion.php");
        // Recuperar la lista de platos del menú desde la base de datos
        $sql = "SELECT * FROM Menu";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['nombre']} ({$row['precio']} USD)";
                echo " <a href='editar_plato.php?id={$row['plato_id']}'>Editar</a>";
                echo " <a href='eliminar_plato.php?id={$row['plato_id']}'>Eliminar</a></li>";
            }
        } else {
            echo "<p>No hay platos en el menú.</p>";
        }
        ?>
    </ul>

    <!-- Formulario para agregar un nuevo plato -->


    <!-- Agregar aquí el código para editar y eliminar platos -->
</body>

</html>