<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Expectation\ResolveLeavingPassengers;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResolvableLeavingStation implements Station, ResolveLeavingPassengers
{
    public function handle(Minibus $bus, array $configuration = [])
    {
        $bus->addPassenger('resolvable_leaving', true);
    }

    public function setLeavingPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['resolvable_leaving']);
        $resolver->setAllowedTypes(['resolvable_leaving' => 'bool']);
    }
}
