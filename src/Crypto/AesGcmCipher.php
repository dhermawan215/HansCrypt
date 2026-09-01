<?php

namespace HansCrypt\Crypto;

use HansCrypt\Contract\CipherInterface;

class AesGcmCipher implements CipherInterface
{
    private string $cipher = 'aes-256-gcm';

    public function encrypt(string $plain, string $key): string
    {
        $iv = random_bytes(12);
        $tag = '';

        $key = substr(hash('sha256', $key, true), 0, 32);

        $encrypted = openssl_encrypt(
            $plain,
            $this->cipher,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return $iv . $tag . $encrypted;
    }

    public function decrypt(string $payload, string $key): ?string
    {
        if (strlen($payload) < 28) {
            return null;
        }

        $iv = substr($payload, 0, 12);
        $tag = substr($payload, 12, 16);
        $ciphertext = substr($payload, 28);

        $key = substr(hash('sha256', $key, true), 0, 32);

        $plain = openssl_decrypt(
            $ciphertext,
            $this->cipher,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return $plain === false ? null : $plain;
    }
}
