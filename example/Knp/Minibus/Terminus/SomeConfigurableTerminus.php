<?php

namespace example\Knp\Minibus\Terminus;

use Knp\Minibus\Config\ConfigurableTerminus;
use example\Knp\Minibus\Terminus\Configuration\SomeTerminusConfig;
use Knp\Minibus\Minibus;

class SomeConfigurableTerminus implements ConfigurableTerminus
{
    public function terminate(Minibus $bus, array $configuration)
    {
        return $configuration['must_return'];
    }

    public function getConfiguration()
    {
        return new SomeTerminusConfig;
    }
}
