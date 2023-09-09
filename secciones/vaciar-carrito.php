<?php
session_start();

if (isset($_SESSION['carrito'])) {
    unset($_SESSION['carrito']); // Eliminar todos los productos del carrito
}

// Puedes enviar una respuesta de éxito al cliente si lo deseas
echo "El carrito ha sido vaciado.";
