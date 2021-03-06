<?php

namespace Knp\Minibus\Expectation;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This interface can be used with the ExpectationStopSubscriber class. Those
 * implementations will defined the passengers that must/will/should leave 
 * a Stop.
 */
interface ResolveLeavingPassengers
{
    /**
     * @param OptionsResolver $resolver
     */
    public function setLeavingPassengers(OptionsResolver $resolver);
}
