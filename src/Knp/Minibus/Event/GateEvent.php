<?php

namespace Knp\Minibus\Event;

use Symfony\Component\EventDispatcher\Event;
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

/**
 * This event is raised when a station open and closed a minibus gate. In
 * "software" friendly words, before and after a station "handle" a minibus.
 */
class GateEvent extends Event
{
    /**
     * @var Station $station
     */
    private $station;

    /**
     * @var Minibus $minibus
     */
    private $minibus;

    /**
     * @param Station $station
     * @param Minibus $minibus
     */
    public function __construct(Minibus $minibus, Station $station)
    {
        $this->station = $station;
        $this->minibus = $minibus;
    }

    /**
     * @return Station
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * @return Minibus
     */
    public function getMinibus()
    {
        return $this->minibus;
    }
}
