<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class OtherBasicStation implements Station
{
    public function handle(Minibus $bus)
    {
        $bus->addPassenger('other_basic', true);
    }
}
