<?php
require_once("../../conexion.php");

if (isset($_POST["plato_id"])) {
    $plato_id = $_POST["plato_id"];

    // Utilizamos una consulta preparada para eliminar el producto
    $query = "DELETE FROM menu WHERE plato_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Vinculamos el valor del plato_id
    mysqli_stmt_bind_param($stmt, "i", $plato_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Producto eliminado correctamente";
        header("Location:../index.php");
    } else {
        echo "Error al eliminar el producto";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "No se ha recibido el ID del producto";
}
