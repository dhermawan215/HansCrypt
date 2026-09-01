<?php

namespace HansCrypt\Tests;

use HansCrypt\Exception\InvalidKeyException;
use HansCrypt\SecureEncryption;
use PHPUnit\Framework\TestCase;

class SecureEncryptionTest extends TestCase
{
    public function test_it_round_trips_an_integer_id(): void
    {
        $secure = new SecureEncryption('test-key');

        $token = $secure->encode(123);

        $this->assertSame(123, $secure->decode($token));
    }

    public function test_it_round_trips_a_string_id(): void
    {
        $secure = new SecureEncryption('test-key');

        $token = $secure->encode('user-abc');

        $this->assertSame('user-abc', $secure->decode($token));
    }

    public function test_decoding_garbage_returns_null(): void
    {
        $secure = new SecureEncryption('test-key');

        $this->assertNull($secure->decode('not-a-valid-token'));
    }

    public function test_decoding_a_token_with_a_different_key_returns_null(): void
    {
        $token = (new SecureEncryption('key-one'))->encode(123);

        $this->assertNull((new SecureEncryption('key-two'))->decode($token));
    }

    public function test_empty_key_throws(): void
    {
        $this->expectException(InvalidKeyException::class);

        new SecureEncryption('');
    }
}
