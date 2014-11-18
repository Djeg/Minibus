<?php

namespace Knp\Minibus\Event;

use Symfony\Component\EventDispatcher\Event;
use Knp\Minibus\Minibus;
use Knp\Minibus\Terminus\Terminus;

/**
 * This event is launched before a terminus is called inside a line.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class TerminusEvent extends Event
{
    /**
     * @var Minibus $minibus
     */
    private $minibus;

    /**
     * @var Terminus $terminus
     */
    private $terminus;

    /**
     * @var array $configuration
     */
    private $configuration;

    public function __construct(Minibus $minibus, Terminus $terminus = null, array $configuration = [])
    {
        $this->minibus       = $minibus;
        $this->terminus      = $terminus;
        $this->configuration = $configuration;
    }

    /**
     * @return Minibus
     */
    public function getMinibus()
    {
        return $this->minibus;
    }

    /**
     * @return Terminus|null
     */
    public function getTerminus()
    {
        return $this->terminus;
    }

    /**
     * @param Terminus $terminus
     *
     * @return TerminusEvent
     */
    public function setTerminus(Terminus $terminus)
    {
        $this->terminus = $terminus;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param array $configuration
     *
     * @return TerminusEvent
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }
}
