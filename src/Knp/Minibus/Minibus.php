<?php

namespace Knp\Minibus;

/**
 * A minibus is a simple vehicle for passengers, understand a vehicle for
 * data. Rememberto drive carefully ! The man who don't drink, can drive.
 */
interface Minibus
{
    /**
     * @api
     *
     * @param mixed $name
     * @param mixed $passenger
     *
     * @return Minibus
     */
    public function addPassenger($name, $passenger);

    /**
     * @api
     *
     * @param mixed $name
     * @param mixed $defaultPassenger
     *
     * @return mixed|null
     */
    public function getPassenger($name, $defaultPassenger = null);

    /**
     * @api
     *
     * @param mixed $name
     *
     * @return boolean
     */
    public function hasPassenger($name);

    /**
     * @api
     *
     * @param array $passengers
     *
     * @return Minibus
     */
    public function setPassengers(array $passengers);

    /**
     * @api
     *
     * @param string $name
     *
     * @return Minibus
     */
    public function removePassenger($name);

    /**
     * @api
     *
     * @return array
     */
    public function getPassengers();
}
