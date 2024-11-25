<?php
$host = 'sql102.infinityfree.com';
$dbname = 'if0_37746648_inventory_management';
$username = 'if0_37746648';
$password = 'dbpro14102003';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'Conexión exitosa';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
