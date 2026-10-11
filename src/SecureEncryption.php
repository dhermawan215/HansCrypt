<?php

namespace HansCrypt;

use HansCrypt\Contract\CipherInterface;
use HansCrypt\Contract\SecureEncryptionInterface;
use HansCrypt\Crypto\AesGcmCipher;
use HansCrypt\Exception\InvalidKeyException;
use HansCrypt\Support\Base64Url;

class SecureEncryption implements SecureEncryptionInterface
{
    private CipherInterface $cipher;

    public function __construct(
        private string $key,
        ?CipherInterface $cipher = null
    ) {
        if ($this->key === '') {
            throw new InvalidKeyException('HansCrypt encryption key must not be empty.');
        }

        $this->cipher = $cipher ?? new AesGcmCipher();
    }

    public function encode(string|int $id): string
    {
        $payload = json_encode([
            'id' => $id,
        ]);

        $encrypted = $this->cipher->encrypt($payload, $this->key);

        return Base64Url::encode($encrypted);
    }

    public function decode(string $token): string|int|null
    {
        $decoded = Base64Url::decode($token);

        if (!$decoded) return null;

        $plain = $this->cipher->decrypt($decoded, $this->key);

        if (!$plain) return null;

        $data = json_decode($plain, true);

        return $data['id'] ?? null;
    }

    public function decodeMany(array $tokens): array
    {
        return array_map(
            fn ($token) => is_string($token) ? $this->decode($token) : null,
            $tokens
        );
    }
}
