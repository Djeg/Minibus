<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class BasicStation implements Station
{
    public function handle(Minibus $bus, array $configuration = [])
    {
        $bus->addPassenger('basic', true);
    }
}
