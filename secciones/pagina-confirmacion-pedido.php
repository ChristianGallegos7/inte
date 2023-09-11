<?php
// Inicia la sesión si aún no está iniciada
session_start();

// Elimina la variable de sesión que contiene el carrito
unset($_SESSION['carrito']);

// Otros procesos de confirmación y visualización de mensajes de confirmación aquí
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Confirmación de Pedido</h1>
        <p>Tu pedido se está procesando. Gracias por tu compra.</p>
        <div>
            <a href="pdfs/mi_pdf.pdf" target="_blank" class="btn btn-primary">Ver Factura en PDF</a>
            <strong>NOTA: Debe descargar el pdf de su factura ahora, no podra hacerlo luego</strong>
        </div>
        <a href="local.php" class="btn btn-secondary mt-3">Volver a locales</a>


    </div>
</body>

</html>