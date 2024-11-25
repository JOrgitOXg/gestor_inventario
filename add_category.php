<?php
include 'conexion.php';

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {
        $category_name = htmlspecialchars($category_name);

        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$category_name]);

            $successMessage = 'Categoría agregada con éxito.';
            header('Refresh: 2; url=index.php');
            exit;
        } catch (Exception $e) {
            $errorMessage = 'Error al agregar la categoría: ' . $e->getMessage();
        }
    } else {
        $errorMessage = 'El nombre de la categoría no puede estar vacío.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Categoría</title>
    <link rel="icon" href="inventario.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container my-5 shadow-lg rounded">
    <header class="text-center py-4 bg-success text-white rounded-top">
        <h1>Agregar Categoría</h1>
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

        <form action="add_category.php" method="POST" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="category_name" class="form-label">Nombre de la Categoría</label>
                <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Ejemplo: Electrónica" required value="<?= isset($category_name) ? htmlspecialchars($category_name) : '' ?>">
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
