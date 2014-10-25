<?php

namespace Knp\Minibus;

/**
 * A station is a given step in a minibus travel. You can pass it to an
 * line in order to handle a minibus.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface Station
{
    /**
     * @TODO rename this method
     * @param Minibus $minibus
     */
    public function handle(Minibus $minibus);
}
