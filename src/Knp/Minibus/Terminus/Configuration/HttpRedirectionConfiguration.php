<?php

namespace Knp\Minibus\Terminus\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Defined the configuration of an HttpRedirectionTerminus.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class HttpRedirectionConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder;
        $root = $tree->root('http_redirection');

        $root
            ->children()
                ->scalarNode('target')
                ->end()
            ->end()
        ;

        return $tree;
    }
}
