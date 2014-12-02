<?php

namespace Knp\Minibus\Expectation;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This interface can be used with the ExpectationStopSubscriber class. Those
 * implementation will defined the passengers that must/will/should enter 
 * in a Stop.
 */
interface ResolveEnteringPassengers
{
    /**
     * @param OptionsResolver $resolver
     */
    public function setEnteringPassengers(OptionsResolver $resolver);
}
