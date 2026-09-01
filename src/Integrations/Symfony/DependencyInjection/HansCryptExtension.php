<?php

namespace HansCrypt\Integrations\Symfony\DependencyInjection;

use HansCrypt\Contract\SecureEncryptionInterface;
use HansCrypt\SecureEncryption;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

final class HansCryptExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $definition = new Definition(SecureEncryption::class, [$config['key']]);
        $definition->setPublic(true);

        $container->setDefinition(SecureEncryption::class, $definition);
        $container->setAlias(SecureEncryptionInterface::class, SecureEncryption::class)->setPublic(true);
    }

    public function getAlias(): string
    {
        return 'hanscrypt';
    }
}
