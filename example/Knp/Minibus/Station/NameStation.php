<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class NameStation implements Station
{
    public function handle(Minibus $minibus)
    {
        $minibus->addPassenger('name', 'minibus');
    }
}
