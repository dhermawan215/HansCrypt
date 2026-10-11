<?php

namespace HansCrypt\Contract;

interface SecureEncryptionInterface
{
    public function encode(string|int $id): string;

    public function decode(string $token): string|int|null;

    /**
     * Decode many tokens at once. Keys are preserved; invalid tokens map to null.
     *
     * @param array<array-key, string> $tokens
     * @return array<array-key, string|int|null>
     */
    public function decodeMany(array $tokens): array;
}
