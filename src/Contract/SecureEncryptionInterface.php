<?php

namespace HansCrypt\Contract;

interface SecureEncryptionInterface
{
    public function encode(string|int $id): string;

    public function decode(string $token): string|int|null;
}
