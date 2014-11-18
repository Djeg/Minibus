<?php

namespace example\Knp\Minibus\Terminus\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class SomeTerminusConfig implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder;
        $root = $tree->root('some_terminus');

        $root
            ->children()
                ->scalarNode('must_return')
                    ->defaultValue('default')
                ->end()
            ->end()
        ;

        return $tree;
    }
}
