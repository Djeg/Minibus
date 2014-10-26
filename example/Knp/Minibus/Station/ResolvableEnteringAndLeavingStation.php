<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Expectation\ResolveEnteringPassengers;
use Knp\Minibus\Expectation\ResolveLeavingPassengers;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResolvableEnteringAndLeavingStation implements Station,
                                                     ResolveEnteringPassengers,
                                                     ResolveLeavingPassengers
{
    public function handle(Minibus $bus)
    {
        $bus->addPassenger('resolvable_entering_and_leaving', true);
    }

    public function setEnteringPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['basic']);
    }

    public function setLeavingPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['resolvable_entering_and_leaving']);
    }
}
