<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link rel="icon" href="inventario.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="container my-5 shadow-lg rounded">
    <header class="text-center py-4 bg-danger text-white rounded-top">
        <h1>Eliminar Producto</h1>
        <a href="index.php" class="btn btn-light shadow">
            <i class="fa fa-arrow-left"></i> Volver
        </a>
    </header>

    <main class="p-4">
        <div class="alert alert-danger text-center" role="alert">
            <strong>¡Advertencia!</strong> Esta acción eliminará el producto permanentemente.
        </div>
        <div class="text-center">
            <form method="POST" action="delete_product.php?id=<?= $_GET['id'] ?>" class="d-inline">
                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="fa fa-trash"></i> Eliminar Producto
                </button>
            </form>
            <a href="index.php" class="btn btn-secondary btn-lg">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </main>

    <footer class="bg-success text-white text-center py-3 rounded-bottom">
        <p class="mb-0">&copy; 2024 Gestión de Inventario. Jorge Guadalupe Gómez Pimentel.</p>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
