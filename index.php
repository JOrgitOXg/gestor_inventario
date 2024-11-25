<?php
include 'conexion.php';

$query = $pdo->query("SELECT products.id, products.name, products.price, products.stock, categories.name as category 
                      FROM products 
                      JOIN categories ON products.category_id = categories.id");
$products = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario</title>
    <link rel="icon" href="inventario.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container-fluid my-5 shadow-lg rounded">
    <header class="text-center py-4 bg-success text-white rounded-top">
        <h1 class="mb-3">Gestión de Inventario</h1>
        <nav class="d-flex justify-content-center flex-wrap">
            <a href="add_product.php" class="btn btn-light me-2 mb-2 shadow">
                <i class="fa fa-plus-circle"></i> Agregar Producto
            </a>
            <a href="add_category.php" class="btn btn-light me-2 mb-2 shadow">
                <i class="fa fa-folder-plus"></i> Agregar Categoría
            </a>
            <a href="transactions.php" class="btn btn-light mb-2 shadow">
                <i class="fa fa-list"></i> Transacciones
            </a>
        </nav>
    </header>

    <main class="p-4">
        <h2 class="text-success text-center mb-4">Listado de Productos</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['category']) ?></td>
                            <td>$<?= number_format(htmlspecialchars($product['price']), 2) ?></td>
                            <td><?= htmlspecialchars($product['stock']) ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Eliminar
                                </a>
                                <a href="view_product.php?id=<?= $product['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-success text-white text-center py-3 rounded-bottom">
        <p class="mb-0">&copy; 2024 Gestión de Inventario. Jorge Guadalupe Gómez Pimentel.</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
