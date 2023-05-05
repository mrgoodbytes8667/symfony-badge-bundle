<?php


namespace Bytes\SymfonyBadge\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bytes_symfony_badge');

        $treeBuilder->getRootNode()
            ->ignoreExtraKeys()
            ->children()
                ->scalarNode('cache_path')
                    ->cannotBeEmpty()
                    ->info('Fully qualified path to cache')
                    ->defaultValue('%kernel.project_dir%/var/cache/%kernel.environment%/bytes_symfony_badge')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
