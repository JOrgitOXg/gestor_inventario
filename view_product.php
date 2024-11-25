<?php
include 'conexion.php';

$product_id = $_GET['id'];
$product = $pdo->prepare("SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.id = ?");
$product->execute([$product_id]);
$product = $product->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Producto</title>
    <link rel="icon" href="inventario.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container-fluid my-5 shadow-lg rounded">
    <header class="text-center py-4 bg-success text-white rounded-top">
        <h1>Detalles del Producto</h1>
        <a href="index.php" class="btn btn-light shadow btn-block">
            <i class="fa fa-arrow-left"></i> Volver
        </a>
    </header>
    
    <main class="p-4">
        <div class="border p-4 rounded shadow-sm bg-light">
            <h3 class="text-success"><?= htmlspecialchars($product['name']) ?></h3>
            <p><strong>Categoría:</strong> <?= htmlspecialchars($product['category_name']) ?></p>
            <p><strong>Precio:</strong> $<?= number_format(htmlspecialchars($product['price']), 2) ?></p>
            <p><strong>Stock:</strong> <?= htmlspecialchars($product['stock']) ?></p>
            <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
        </div>
    </main>

    <footer class="bg-success text-white text-center py-3 rounded-bottom">
        <p class="mb-0">&copy; 2024 Gestión de Inventario. Jorge Guadalupe Gómez Pimentel.</p>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
