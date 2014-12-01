<?php

namespace Knp\Minibus\Expectation;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This interface can be used with the ExpectationStopSubscriber class. This
 * on defined the passengers that must/will/should enter in a Stop.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface ResolveEnteringPassengers
{
    /**
     * @param OptionsResolver $resolver
     */
    public function setEnteringPassengers(OptionsResolver $resolver);
}
