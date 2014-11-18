<?php

namespace Knp\Minibus;

use Knp\Minibus\Terminus\Terminus;

/**
 * A minibus is led by this instance of a line in order of acheive the
 * requested destination. Please have a good trip ^.^
 *
 * @author David Jegat <david.jegat@gmail.com>
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
