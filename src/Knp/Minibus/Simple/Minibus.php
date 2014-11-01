<?php

namespace Knp\Minibus\Simple;

use Knp\Minibus\Minibus as MinibusInterface;

/**
 * A very simple implementation of a minibus storing passengers in memory.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class Minibus implements MinibusInterface, \IteratorAggregate
{
    /**
     * @var array $passengers
     */
    private $passengers;

    public function __construct()
    {
        $this->passengers = [];
    }

    /**
     * {@inheritdoc}
     */
    public function addPassenger($name, $passenger)
    {
        $this->passengers[$name] = $passenger;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassenger($name, $defaultPassenger = null)
    {
        if (!isset($this->passengers[$name])) {
            return $defaultPassenger;
        }

        return $this->passengers[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function removePassenger($name)
    {
        if (!isset($this->passengers[$name])) {
            return $this;
        }

        unset($this->passengers[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassengers(array $passengers)
    {
        $this->passengers = $passengers;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->passengers);
    }
}
