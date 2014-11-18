<?php

namespace Knp\Minibus;

/**
 * A station is a given step in a minibus travel. You can pass it to a
 * line in order to handle a minibus.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface Station
{
    /**
     * @param Minibus $minibus
     * @param array   $configuration
     */
    public function handle(Minibus $minibus, array $configuration = []);
}
