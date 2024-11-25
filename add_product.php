<?php
include 'conexion.php';

$categories = $pdo->query("SELECT id, name FROM categories")->fetchAll();

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    if (!empty($name) && !empty($price) && !empty($stock) && !empty($category_id)) {
        if (is_numeric($price) && is_numeric($stock)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock, category_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $stock, $category_id]);
                
                $successMessage = 'Producto agregado con éxito.';
                header('Refresh: 2; url=index.php');
                exit;
            } catch (Exception $e) {
                $errorMessage = 'Error al agregar el producto: ' . $e->getMessage();
            }
        } else {
            $errorMessage = 'El precio y el stock deben ser números válidos.';
        }
    } else {
        $errorMessage = 'Por favor, complete todos los campos obligatorios.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="icon" href="inventario.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container my-5 shadow-lg rounded">
    <header class="text-center py-4 bg-success text-white rounded-top">
        <h1>Agregar Producto</h1>
        <a href="index.php" class="btn btn-light shadow">
            <i class="fa fa-arrow-left"></i> Volver
        </a>
    </header>

    <main class="p-4">
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php elseif ($successMessage): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>

        <form action="add_product.php" method="POST" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Producto</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Ejemplo: Smartphone" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Breve descripción del producto"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="Ejemplo: 299.99" required value="<?= isset($price) ? htmlspecialchars($price) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" placeholder="Ejemplo: 50" required value="<?= isset($stock) ? htmlspecialchars($stock) : '' ?>">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Categoría</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= isset($category_id) && $category_id == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">
                <i class="fa fa-save"></i> Guardar
            </button>
        </form>
    </main>

    <footer class="bg-success text-white text-center py-3 rounded-bottom">
        <p class="mb-0">&copy; 2024 Gestión de Inventario. Jorge Guadalupe Gómez Pimentel.</p>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
