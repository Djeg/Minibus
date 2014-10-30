<?php

namespace Knp\Minibus;

/**
 * A minibus is led by this instance of a line in order of acheive the
 * requested destination. Please have a good trip ^.^
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface Line
{
    /**
     * @param Station $station
     */
    public function addStation(Station $station);

    /**
     * @param Minibus $bus
     */
    public function lead(Minibus $bus);
}
