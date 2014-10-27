<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Minibus;

/**
 * A terminus can terminate a minibus, deal with passengers and tranform a
 * minibus to something else like an http response or an internet cat ^.^.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface Terminus
{
    /**
     * @param Minibus $minibus
     *
     * @return mixed
     */
    public function terminate(Minibus $minibus, array $config);
}
