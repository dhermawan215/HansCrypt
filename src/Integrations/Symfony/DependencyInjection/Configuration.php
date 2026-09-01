<?php

namespace HansCrypt\Integrations\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('hanscrypt');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('key')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Secret key used to encrypt/decrypt IDs. Keep it secret and stable.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
