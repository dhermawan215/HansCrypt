# HansCrypt

[Repository](https://github.com/dhermawan215/HansCrypt) · [Issues](https://github.com/dhermawan215/HansCrypt/issues)

Framework-agnostic, reversible ID/URL obfuscation for PHP, backed by AES-256-GCM.

Turn `/users/482` into `/users/9x3F...` and back — without a lookup table, and without leaking your database schema or letting anyone enumerate IDs.

Works as a plain PHP class in any codebase, with first-class integrations for **Laravel** and **Symfony**, and a generic factory for any **PSR-11** container (Slim, Mezzio, PHP-DI, League\Container, ...).

Part of the **HansSuite** ecosystem by **Nusantara Innovation Technology**.

## Installation

```bash
composer require hanssuite/hanscrypt
```

Requires PHP 8.1+ and the `openssl` extension. No framework is required — Laravel/Symfony packages are only needed if you use those integrations (see below).

Not yet on Packagist? Install straight from GitHub by adding a VCS repository to your `composer.json`:

```json
{
  "repositories": [
    { "type": "vcs", "url": "https://github.com/dhermawan215/HansCrypt" }
  ]
}
```

then run `composer require hanssuite/hanscrypt:dev-main`.

## Quick start (native PHP / any framework)

```php
use HansCrypt\SecureEncryption;

$secure = new SecureEncryption($_ENV['HANSCRYPT_KEY']);

$token = $secure->encode(482);      // "gk1Z3n9Q..."
$id = $secure->decode($token);      // 482

$secure->decode('garbage');         // null — invalid/tampered tokens never throw

$ids = $secure->decodeMany([$token, 'garbage']);   // [482, null]
```

- `encode(string|int $id): string` — returns a URL-safe token.
- `decode(string $token): string|int|null` — returns the original ID, or `null` if the token is invalid, tampered with, or was encrypted with a different key.
- `decodeMany(array $tokens): array` — decodes an array of tokens in one call. Array keys are preserved, and any invalid token (or non-string entry) becomes `null` at its position.
- The constructor throws `HansCrypt\Exception\InvalidKeyException` if given an empty key.

Keep the key secret and stable: rotating it invalidates every previously issued token.

A full runnable example (product list → obfuscated-ID links → detail page) is in [`examples/native-php`](examples/native-php). Run it with:

```bash
php -S 127.0.0.1:8000 -t examples/native-php
```

Then open `http://127.0.0.1:8000/index.php`.

## Laravel

The service provider is auto-discovered. Set a key and go:

```env
HANSCRYPT_KEY=base64:your-long-random-secret
```

```php
use HansCrypt\SecureEncryption;
use HansCrypt\Contract\SecureEncryptionInterface;

class UserController
{
    public function __construct(private SecureEncryptionInterface $secure) {}

    public function show(string $token)
    {
        $id = $this->secure->decode($token);
        // ...
    }
}
```

`SecureEncryption::class` is bound as a singleton and aliased to `SecureEncryptionInterface::class`, so you can type-hint either.

Publish the config file if you want to customize it:

```bash
php artisan vendor:publish --tag=hanscrypt-config
```

## Symfony

Register the bundle in `config/bundles.php`:

```php
return [
    // ...
    HansCrypt\Integrations\Symfony\HansCryptBundle::class => ['all' => true],
];
```

Configure it in `config/packages/hanscrypt.yaml`:

```yaml
hanscrypt:
    key: '%env(HANSCRYPT_KEY)%'
```

Then autowire it anywhere:

```php
use HansCrypt\Contract\SecureEncryptionInterface;

class UserController
{
    public function __construct(private SecureEncryptionInterface $secure) {}
}
```

## Any other PSR-11 container (Slim, Mezzio, PHP-DI, League\Container, ...)

```php
use HansCrypt\Integrations\ContainerFactory;
use HansCrypt\SecureEncryption;

$container->set(SecureEncryption::class, fn ($c) => ContainerFactory::make($c));
```

`ContainerFactory::make()` reads the key from the container entry `hanscrypt.key` (configurable), falling back to the `HANSCRYPT_KEY` environment variable.

## Security notes

- The key is hashed with SHA-256 before use, so any string length works as input, but you should still use a long, random secret (32+ bytes) — not a short or guessable value.
- Losing the key means every existing token becomes permanently undecryptable; rotating it invalidates all previously issued tokens.
- `decode()` never throws on malformed input — it returns `null`, so it's safe to call directly on untrusted URL segments.

## Testing

```bash
composer install
composer test
```

## HansSuite ecosystem

HansCrypt is one component of **HansSuite**, a collection of open-source PHP packages built by **Nusantara Innovation Technology** to solve common, cross-framework problems — each one framework-agnostic at its core, with the same first-class Laravel/Symfony/PSR-11 integration pattern.

Questions, ideas, or issues? Reach out at **support@nusainnotech.com**.

## License

MIT
