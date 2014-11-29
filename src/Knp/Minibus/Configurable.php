<?php

namespace Knp\Minibus;

/**
 * Defined a station or a terminus has configurable.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface Configurable
{
    /**
     * @return \Symfony\Component\Config\Definition\ConfigurationInterface
     */
    public function getConfiguration();
}
