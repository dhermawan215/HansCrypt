<?php

declare(strict_types=1);

/** @var \HansCrypt\SecureEncryption $secure */
$secure = require __DIR__ . '/bootstrap.php';
$products = require __DIR__ . '/products.php';

$token = $_GET['id'] ?? '';
$id = $secure->decode($token);

if ($id === null || !isset($products[$id])) {
    http_response_code(404);
    echo '<h1>404 — product not found</h1>';
    echo '<p>Either the token is invalid/tampered with, or was never issued by this app.</p>';
    exit;
}

$product = $products[$id];

?><!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title><?= htmlspecialchars($product['name']) ?></title></head>
<body>
<p><a href="index.php">&larr; back to products</a></p>
<h1><?= htmlspecialchars($product['name']) ?></h1>
<p>Price: $<?= number_format($product['price'], 2) ?></p>
<p>Decoded database id (never shown in the URL): <code><?= $id ?></code></p>
</body>
</html>
