<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class OtherBasicStation implements Station
{
    public function handle(Minibus $bus, array $configuration = [])
    {
        $bus->addPassenger('other_basic', true);
    }
}
