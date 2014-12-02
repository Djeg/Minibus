<?php

namespace Knp\Minibus\Terminus\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Defined the configuration for the RouteRedirectionTerminus.
 */
class RouteRedirectionConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $root    = $builder->root('route_redirection');

        $root
            ->children()
                ->scalarNode('route')
                    ->isRequired()
                ->end()
                ->variableNode('parameters')
                    ->beforeNormalization()
                        ->always()
                        ->then(function ($value) {
                            if (!is_array($value)) {
                                return (array)$value;
                            }

                            return $value;
                        })
                    ->end()
                    ->defaultValue([])
                ->end()
                ->scalarNode('type')
                    ->validate()
                        ->ifNotInArray(['url', 'absolute', 'relative', 'network'])
                        ->thenInvalid('Invalid route generation type "%s"')
                    ->end()
                    ->defaultValue('absolute')
                ->end()
            ->end()
        ;

        return $builder;
    }
}
