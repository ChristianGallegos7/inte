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

    // Recalcula el subtotal y el total
    $subtotal = 0;
    foreach ($_SESSION['carrito'] as $producto) {
        $subtotal += $producto['cantidad'] * $producto['precio'];
    }
    $total = $subtotal; // Puedes agregar impuestos u otros costos adicionales aquí si es necesario

    // Devuelve una respuesta JSON con el subtotal y el total actualizados
    echo json_encode(array(
        'subtotal' => $subtotal,
        'total' => $total
    ));
}
