<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Knp\Minibus\Expectation\ResolveEnteringPassengers;

class ResolvableEnteringStation implements Station, ResolveEnteringPassengers
{
    public function handle(Minibus $bus)
    {
        $bus->addPassenger('resolvable_entering', true);
    }

    public function setEnteringPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired('basic');
        $resolver->setAllowedTypes(['basic' => 'bool']);
    }
}
