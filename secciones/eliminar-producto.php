<?php
session_start();

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    if (isset($_SESSION['carrito'][$productId])) {
        unset($_SESSION['carrito'][$productId]);
        echo 'success'; // Producto eliminado con éxito
    } else {
        echo 'El producto no se encontró en el carrito.';
    }
} else {
    echo 'ID del producto no proporcionado.';
}
