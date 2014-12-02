<?php

namespace Knp\Minibus;

/**
 * Defined a station or a terminus has configurable.
 */
interface Configurable
{
    /**
     * @api
     *
     * @return \Symfony\Component\Config\Definition\ConfigurationInterface
     */
    public function getConfiguration();
}
