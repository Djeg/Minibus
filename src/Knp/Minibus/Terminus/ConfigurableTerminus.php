<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Minibus;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * handle a minibus terminus but this time with configuration.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface ConfigurableTerminus extends Terminus
{
    /**
     * @param NodeParentInterface $node
     */
    public function configure(ArrayNodeDefinition $node);
}
