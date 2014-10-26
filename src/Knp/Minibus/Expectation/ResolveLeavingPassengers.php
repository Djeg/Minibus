<?php

namespace Knp\Minibus\Expectation;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * This interface can be used with the ExpectationStopSubscriber class. This
 * on defined the passengers that must/will/should leave a Stop.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface ResolveLeavingPassengers
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setLeavingPassengers(OptionsResolverInterface $resolver);
}
