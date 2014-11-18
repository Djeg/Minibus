<?php

namespace Knp\Minibus\Collection;

use Knp\Minibus\Station;

/**
 * Collect station and configuration and can iterate thrue all.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class StationCollection implements \Iterator
{
    /**
     * @var Station[] $stations
     */
    private $stations;

    /**
     * @var array $configurations
     */
    private $configuration;

    /**
     * @var integer $index
     */
    private $index;

    public function __construct()
    {
        $this->stations       = [];
        $this->configurations = [];
        $this->index          = 0;
    }

    /**
     * @param Station $station
     * @param array   $configuration
     *
     * @return StationCollection
     */
    public function add(Station $station, array $configuration = [])
    {
        $this->stations[]       = $station;
        $this->configurations[] = $configuration;

        return $this;
    }

    /**
     * @param Station $station
     *
     * @return boolean
     */
    public function contains(Station $station)
    {
        foreach ($this->stations as $existentStation) {
            if ($existentStation === $station) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function current()
    {
        return $this->configurations[$this->index];
    }

    /**
     * @return Station
     */
    public function key()
    {
        return $this->stations[$this->index];
    }

    public function next()
    {
        $this->index += 1;
    }

    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return isset($this->stations[$this->index]);
    }
}
