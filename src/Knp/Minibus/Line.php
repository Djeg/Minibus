<?php

namespace Knp\Minibus;

use Knp\Minibus\Terminus;

/**
 * A minibus is lead by this implementation of a line in order of acheive the
 * requested destination. Please have a good trip ^.^
 */
interface Line
{
    /**
     * @api
     * @param Station $station
     * @param array   $configuration
     *
     * @return Line
     */
    public function addStation(Station $station, array $configuration = []);

    /**
     * @api
     * @param Terminus $terminus
     * @param array    $configuration
     *
     * @return Line
     */
    public function setTerminus(Terminus $terminus, array $configuration = []);

    /**
     * @api
     * @param Minibus $bus
     */
    public function lead(Minibus $bus);

    /**
     * @api
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getDispatcher();

}
