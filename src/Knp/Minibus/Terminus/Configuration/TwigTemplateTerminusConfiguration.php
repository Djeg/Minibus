<?php

namespace Knp\Minibus\Terminus\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Defined how a TwigTemplateTerminus should be configured.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class TwigTemplateTerminusConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode    = $treeBuilder->root('twig_template');

        $rootNode
            ->children()
                ->scalarNode('template')->end()
                ->scalarNode('key')
                    ->defaultValue('')
                ->end()
                ->variableNode('defaults')
                    ->defaultValue([])
                    ->beforeNormalization()
                        ->always()
                        ->then(function ($v) {
                            if (!is_array($v)) {
                                return (array)$v;
                            }

                            return $v;
                        })
                    ->end()
                ->end()
             ->end()
        ;

        return $treeBuilder;
    }
}
