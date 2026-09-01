<?php

namespace HansCrypt\Contract;

interface CipherInterface
{
    public function encrypt(string $plain, string $key): string;

    public function decrypt(string $payload, string $key): ?string;
}
