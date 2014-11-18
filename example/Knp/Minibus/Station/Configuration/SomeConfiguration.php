<?php

namespace example\Knp\Minibus\Station\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class SomeConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder;
        $root = $tree->root('some_configurable_station');

        $root
            ->children()
                ->scalarNode('plop')
                    ->defaultValue('plop ?')
                ->end()
            ->end()
        ;

        return $tree;
    }
}
