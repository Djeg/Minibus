<?php

namespace Knp\Minibus;

/**
 * A terminus can terminate a minibus line, deal with passengers and tranform a
 * minibus to something else like an http response or an internet cat ^.^.
 */
interface Terminus
{
    /**
     * @api
     *
     * @param Minibus $minibus
     *
     * @return mixed
     */
    public function terminate(Minibus $minibus, array $config);
}
