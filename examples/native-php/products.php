<?php

declare(strict_types=1);

// Stand-in for a database table — real IDs are plain sequential integers,
// which is exactly what we don't want visible in the URL.
return [
    1 => ['name' => 'Wireless Mouse', 'price' => 15.00],
    2 => ['name' => 'Mechanical Keyboard', 'price' => 89.00],
    3 => ['name' => 'USB-C Hub', 'price' => 32.50],
];
