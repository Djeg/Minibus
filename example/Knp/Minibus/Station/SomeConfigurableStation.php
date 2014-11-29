<?php

namespace example\Knp\Minibus\Station;

use Knp\Minibus\Configurable\ConfigurableStation;
use example\Knp\Minibus\Station\Configuration\SomeConfiguration;
use Knp\Minibus\Minibus;

class SomeConfigurableStation implements ConfigurableStation
{
    public function handle(Minibus $minibus, array $configuration = [])
    {
        $minibus->addPassenger('plop', $configuration['plop']);
    }

    public function getConfiguration()
    {
        return new SomeConfiguration;
    }
}
