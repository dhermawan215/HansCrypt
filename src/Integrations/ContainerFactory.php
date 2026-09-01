<?php

namespace HansCrypt\Integrations;

use HansCrypt\Exception\InvalidKeyException;
use HansCrypt\SecureEncryption;
use Psr\Container\ContainerInterface;

final class ContainerFactory
{
    public static function make(ContainerInterface $container, string $configKey = 'hanscrypt.key'): SecureEncryption
    {
        $key = $container->has($configKey) ? $container->get($configKey) : (getenv('HANSCRYPT_KEY') ?: null);

        if (!is_string($key) || $key === '') {
            throw new InvalidKeyException(
                "Could not resolve a HansCrypt key from container entry '{$configKey}' or the HANSCRYPT_KEY environment variable."
            );
        }

        return new SecureEncryption($key);
    }
}
