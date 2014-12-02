<?php

namespace Knp\Minibus;

/**
 * A station is a given step in a minibus travel. You can pass it to a
 * line in order to handle a minibus.
 */
interface Station
{
    /**
     * @api
     *
     * @param Minibus $minibus
     * @param array   $configuration
     */
    public function handle(Minibus $minibus, array $configuration = []);
}
