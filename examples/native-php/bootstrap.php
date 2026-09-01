<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use HansCrypt\SecureEncryption;

// In a real app, load this from an environment variable / secret manager —
// never hardcode it in source control. This demo key exists only so the
// example runs standalone with `php -S`.
$key = getenv('HANSCRYPT_KEY') ?: 'demo-only-not-a-real-secret-32bytes!!';

return new SecureEncryption($key);
