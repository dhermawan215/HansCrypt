<?php

namespace HansCrypt\Tests\Crypto;

use HansCrypt\Crypto\AesGcmCipher;
use PHPUnit\Framework\TestCase;

class AesGcmCipherTest extends TestCase
{
    public function test_it_round_trips_plaintext(): void
    {
        $cipher = new AesGcmCipher();

        $encrypted = $cipher->encrypt('hello world', 'secret');

        $this->assertSame('hello world', $cipher->decrypt($encrypted, 'secret'));
    }

    public function test_tampered_ciphertext_fails_to_decrypt(): void
    {
        $cipher = new AesGcmCipher();

        $encrypted = $cipher->encrypt('hello world', 'secret');
        $tampered = substr($encrypted, 0, -1) . chr(ord(substr($encrypted, -1)) ^ 1);

        $this->assertNull($cipher->decrypt($tampered, 'secret'));
    }

    public function test_short_payload_returns_null(): void
    {
        $cipher = new AesGcmCipher();

        $this->assertNull($cipher->decrypt('too-short', 'secret'));
    }
}
