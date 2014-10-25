<?php

namespace Knp\Minibus\Event;

use Symfony\Component\EventDispatcher\Event;
use Knp\Minibus\Minibus;

/**
 * This event is raised after the final station. It can "alterate" the minibus
 * passengers by returning a final data.
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
     * @var mixed $finalData
     */
    private $finalData;

    /**
     * @param Minibus $minibus
     */
    public function __construct(Minibus $minibus)
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

    /**
     * @param mixed $finalData
     */
    public function setFinalData($finalData)
    {
        $this->finalData = $finalData;
    }

    /**
     * @return mixed
     */
    public function getFinalData()
    {
        return $this->finalData;
    }
}
