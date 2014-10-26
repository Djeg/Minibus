<?php

namespace Knp\Minibus\Event;

use Knp\Minibus\Minibus;
use Knp\Minibus\Station;

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
     *
     * @return TerninusEvent
     */
    public function createTerminus(Minibus $minibus)
    {
        return new TerminusEvent($minibus);
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
}
