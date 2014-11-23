<?php

namespace Knp\Minibus\Terminus\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Defined the configuration allowed by the JmsSerializerTerminus.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class JmsSerializerTerminusConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode    = $treeBuilder->root('jms_serializer');

        $rootNode
            ->children()
                ->scalarNode('format')
                    ->defaultValue('json')
                    ->validate()
                    ->ifNotInArray(['json', 'xml', 'yaml'])
                        ->thenInvalid('Invalid serialization format "%s"')
                    ->end()
                ->end()
                ->arrayNode('map')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($map) {
                            return [$map];
                        })
                    ->end()
                    ->defaultValue([])
                    ->prototype('scalar')->end()
                ->end()
                ->booleanNode('')
                    ->defaultValue(true)
                ->end()
                ->floatNode('version')
                    ->defaultNull()
                ->end()
                ->arrayNode('groups')
                    ->defaultValue([])
                    ->prototype('scalar')->end()
                ->end()
                ->booleanNode('enable_max_depth_check')
                    ->defaultFalse()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
