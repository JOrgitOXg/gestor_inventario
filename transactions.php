<?php
include 'conexion.php';

$queryProducts = $pdo->query("SELECT id, name FROM products");
$products = $queryProducts->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $transactionType = $_POST['transaction_type'];

    $queryInsert = $pdo->prepare("INSERT INTO transactions (product_id, quantity, transaction_type, transaction_date) 
                                  VALUES (?, ?, ?, NOW())");
    $queryInsert->execute([$productId, $quantity, $transactionType]);

    if ($transactionType == 'entry') {
        $queryUpdate = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
    } else {
        $queryUpdate = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    }
    $queryUpdate->execute([$quantity, $productId]);

    header('Location: transactions.php');
    exit;
}

$queryTransactions = $pdo->query("SELECT transactions.id, products.name as product_name, transactions.quantity, transactions.transaction_type, transactions.transaction_date 
                                  FROM transactions 
                                  JOIN products ON transactions.product_id = products.id");
$transactions = $queryTransactions->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones</title>
    <link rel="icon" href="inventario.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="container my-5 shadow-lg rounded">
    <header class="text-center py-4 bg-success text-white rounded-top">
        <h1>Transacciones de Inventario</h1>
        <a href="index.php" class="btn btn-light shadow">
            <i class="fa fa-arrow-left"></i> Volver
        </a>
    </header>

    <section class="p-4 bg-light rounded my-4">
        <h2 class="text-success mb-3">Registrar Transacción</h2>
        <form method="POST" class="border p-4 rounded shadow-sm bg-white">
            <div class="mb-3">
                <label for="product_id" class="form-label">Producto</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <option value="" disabled selected>Seleccione un producto</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Cantidad</label>
                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Ejemplo: 10" min="1" required>
            </div>
            <div class="mb-3">
                <label for="transaction_type" class="form-label">Tipo de Transacción</label>
                <select name="transaction_type" id="transaction_type" class="form-select" required>
                    <option value="" disabled selected>Seleccione el tipo</option>
                    <option value="entry">Entrada</option>
                    <option value="exit">Salida</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrar</button>
        </form>
    </section>

    <section class="p-4 bg-light rounded">
        <h2 class="text-success mb-3">Historial de Transacciones</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['product_name']) ?></td>
                            <td><?= htmlspecialchars($transaction['quantity']) ?></td>
                            <td class="text-capitalize">
                                <?= $transaction['transaction_type'] == 'entry' ? 'Entrada' : 'Salida' ?>
                            </td>
                            <td><?= htmlspecialchars($transaction['transaction_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer class="bg-success text-white text-center py-3 rounded-bottom">
        <p class="mb-0">&copy; 2024 Gestión de Inventario. Jorge Guadalupe Gómez Pimentel.</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
