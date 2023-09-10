<?php 

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $action = $_POST['action'];

    if ($action === 'increase') {
        // Aumentar la cantidad del producto en el carrito
        foreach ($_SESSION['carrito'] as &$producto) {
            if ($producto['id'] == $productId) {
                $producto['cantidad']++;
                break;
            }
        }
    } elseif ($action === 'decrease') {
        // Disminuir la cantidad del producto en el carrito
        foreach ($_SESSION['carrito'] as &$producto) {
            if ($producto['id'] == $productId) {
                $producto['cantidad']--;
                if ($producto['cantidad'] <= 0) {
                    // Si la cantidad llega a cero, elimina el producto del carrito
                    unset($producto);
                }
                break;
            }
        }
    }

    // Devuelve una respuesta (puede ser JSON o texto, dependiendo de tu preferencia)
    echo "Cantidad actualizada correctamente.";
}
