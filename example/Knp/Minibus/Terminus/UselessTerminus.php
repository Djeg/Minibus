<?php

namespace example\Knp\Minibus\Terminus;

use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Minibus;

class UselessTerminus implements Terminus
{
    public function terminate(Minibus $minibus, array $config)
    {
        return 'useless';
    }
}
