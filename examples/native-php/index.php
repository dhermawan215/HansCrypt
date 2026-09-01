<?php

declare(strict_types=1);

/** @var \HansCrypt\SecureEncryption $secure */
$secure = require __DIR__ . '/bootstrap.php';
$products = require __DIR__ . '/products.php';

?><!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>HansCrypt native PHP example</title></head>
<body>
<h1>Products</h1>
<ul>
<?php foreach ($products as $id => $product): ?>
    <?php $token = $secure->encode($id); ?>
    <li>
        <a href="product.php?id=<?= urlencode($token) ?>"><?= htmlspecialchars($product['name']) ?></a>
        — real database id: <code><?= $id ?></code>, URL token: <code><?= htmlspecialchars($token) ?></code>
    </li>
<?php endforeach; ?>
</ul>
</body>
</html>
