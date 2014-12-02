<?php

namespace Knp\Minibus\Event;

use Knp\Minibus\Minibus;
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is raised when a line start.
 */
class StartEvent extends Event
{
    /**
     * @var Minibus $minibus
     */
    private $minibus;

    /**
     * @param Minibus $minibus
     */
    public function __construct(Minibus $minibus)
    {
        $this->minibus = $minibus;
    }

    /**
     * @param Minibus $minibus
     */
    public function setMinibus(Minibus $minibus)
    {
        $this->minibus = $minibus;
    }

    /**
     * @return Minibus
     */
    public function getMinibus()
    {
        return $this->minibus;
    }
}
