<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Expectation\ResolveEnteringPassengers;
use Knp\Minibus\Expectation\ResolveLeavingPassengers;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResolvableEnteringAndLeavingStation implements Station,
                                                     ResolveEnteringPassengers,
                                                     ResolveLeavingPassengers
{
    public function handle(Minibus $bus, array $configuration = [])
    {
        $bus->addPassenger('resolvable_entering_and_leaving', true);
    }

    public function setEnteringPassengers(OptionsResolver $resolver)
    {
        $resolver->setRequired(['basic']);
    }

    public function setLeavingPassengers(OptionsResolver $resolver)
    {
        $resolver->setRequired(['resolvable_entering_and_leaving']);
    }
}
