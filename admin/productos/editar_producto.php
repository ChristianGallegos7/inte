<?php
require_once("../../conexion.php");

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_producto = mysqli_real_escape_string($conn, $_POST["plato_id"]);
    $nombre_producto = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $descripcion_producto = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $local = mysqli_real_escape_string($conn, $_POST["local_id"]);
    $precio = mysqli_real_escape_string($conn, $_POST["precio"]);
    // Obtener el precio como una cadena
    $precio = $_POST["precio"];

    // Convertir la cadena a un número decimal
    $precio_decimal = number_format((float)$precio, 2, '.', '');
    // Actualizar los datos del producto en la base de datos
    $query = "UPDATE menu SET nombre = ?, descripcion = ?, precio = ?, local_id = ? WHERE plato_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssdsi", $nombre_producto, $descripcion_producto, $precio_decimal, $local, $id_producto);
    mysqli_stmt_execute($stmt);

    // Verificar si se ha seleccionado una nueva imagen para el producto
    if (!empty($_FILES["imagen"]["tmp_name"])) {
        // Obtener los datos de la imagen
        $imagen_nombre = $_FILES["imagen"]["name"];
        $imagen_tipo = $_FILES["imagen"]["type"];
        $imagen_tamano = $_FILES["imagen"]["size"];
        $imagen_temp = $_FILES["imagen"]["tmp_name"];

        // Verificar si la imagen es válida
        if ($imagen_tipo == "image/jpeg" || $imagen_tipo == "image/png") {
            // Leer el contenido de la imagen
            $imagen_contenido = file_get_contents($imagen_temp);

            // Actualizar los datos de la imagen en la base de datos
            $query = "UPDATE menu SET imagen = ? WHERE plato_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "bi", $imagen_contenido, $id_producto);
            mysqli_stmt_send_long_data($stmt, 0, $imagen_contenido);
            mysqli_stmt_execute($stmt);
        }
    }
    // Redirigir al usuario a la página de lista de productos
    header("Location: ../index.php");
    exit();
}

// Obtener el ID del producto de la URL
$id_producto = $_GET["plato_id"];

// Obtener los datos del producto de la base de datos
$query = "SELECT * FROM menu WHERE plato_id = $id_producto";
$resultado = mysqli_query($conn, $query);
$producto = mysqli_fetch_assoc($resultado);

// Obtener los registros de la tabla "local"
$query = "SELECT id_local, Nombre FROM local";
$resultado = mysqli_query($conn, $query);
?>


<!doctype html>
<html lang="en">

<head>
    <title>EDITAR PRODUCTO</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <header>
        <!-- place navbar here -->
        <!-- <div class="container"> -->
        <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between p-4 mx-3">
            <div>
                <img src="../images/avatar.png" alt="" width="50px">
            </div>
            <div class="nav navbar-nav">
                <a class="nav-item nav-link" href="http://localhost/dashboard/trainer/admin/index.php">Admin</a>
                <a class="nav-item nav-link" href="#"></a>
                <a class="nav-item nav-link active btn btn-success text-white" href="#" aria-current="page">Agregar productos <span class="visually-hidden">(current)</span></a>
            </div>
        </nav>
        <!-- </div> -->
    </header>
    <main>
        <h1 class="text-center">Editar producto</h1>
        <div class="container card mt-5">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="plato_id" value="<?php echo $producto["plato_id"]; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto["nombre"]; ?>">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $producto["descripcion"]; ?></textarea>
                </div>
                <!-- <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $producto["stock"]; ?>">
                </div> -->
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto["precio"]; ?>">
                </div>
                <div class="form-group">
                    <label for="local_id">Local:</label>
                    <select class="form-control" id="local_id" name="local_id">
                        <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                            <?php if ($fila["id_local"] == $producto["local_id"]) : ?>
                                <option value="<?php echo $fila["id_local"]; ?>" selected><?php echo $fila["Nombre"]; ?></option>
                            <?php else : ?>
                                <option value="<?php echo $fila["id_local"]; ?>"><?php echo $fila["Nombre"]; ?></option>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input type="file" class="form-control-file mb-3" id="imagen" name="imagen">
                    <?php if (!empty($producto["imagen"])) : ?>
                        <?php
                        $imagen_codificada = base64_encode($producto["imagen"]);
                        echo '<img src="data:image/jpeg;base64,' . $imagen_codificada . '" alt="' . '" width="100">';
                        ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>

                <a name="" id="" class="btn btn-primary mt-3" href="http://localhost/dashboard/inte/admin/index.php" role="button">Cancelar</a>
            </form>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>