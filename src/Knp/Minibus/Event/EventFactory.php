<?php

namespace Knp\Minibus\Event;

use Knp\Minibus\Minibus;
use Knp\Minibus\Station;
use Knp\Minibus\Terminus\Terminus;

/**
 * A simple collaborator for objects that are used to dispatch and creates events.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class EventFactory
{
    /**
     * @param Minibus $minibus
     *
     * @return StartEvent
     */
    public function createStart(Minibus $minibus)
    {
        return new StartEvent($minibus);
    }

    /**
     * @param Minibus $minibus
     * @param Station $station
     *
     * @return GateEvent
     */
    public function createGate(Minibus $minibus, Station $station)
    {
        return new GateEvent($minibus, $station);
    }

    /**
     * @param Minibus $minibus
     * @param Terminus $terminus
     * @param array $configuration
     *
     * @return TerminusEvent
     */
    public function createTerminus(Minibus $minibus, Terminus $terminus = null, array $configuration = [])
    {
        return new TerminusEvent($minibus, $terminus, $configuration);
    }
}
