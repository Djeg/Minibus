<?php

namespace Knp\Minibus\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Create a tree builder.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class TreeBuilderFactory
{
    /**
     * @return TreeBuilder
     */
    public function create()
    {
        return new TreeBuilder;
    }
}
