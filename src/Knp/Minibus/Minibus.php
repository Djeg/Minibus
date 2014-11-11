<?php

namespace Knp\Minibus;

/**
 * A minibus is a simple vehicle for passengers, understand a vehicle for
 * data. Drive carefully !
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface Minibus
{
    /**
     * @param mixed $name
     * @param mixed $passenger
     *
     * @return Minibus
     */
    public function addPassenger($name, $passenger);

    /**
     * @param mixed $name
     * @param mixed $defaultPassenger
     *
     * @return mixed|null
     */
    public function getPassenger($name, $defaultPassenger = null);

    /**
     * @param mixed $name
     *
     * @return boolean
     */
    public function hasPassenger($name);

    /**
     * @param array $passengers
     *
     * @return Minibus
     */
    public function setPassengers(array $passengers);

    /**
     * @param string $name
     *
     * @return Minibus
     */
    public function removePassenger($name);

    /**
     * @return array
     */
    public function getPassengers();
}
