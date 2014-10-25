<?php

namespace Knp\Minibus\Event;

/**
 * All the events dispatched by a, line.
 */
abstract class LineEvents
{
    const START      = 'knp.minibus.start';

    const TERMINUS   = 'knp.minibus.terminus';

    const GATE_OPEN  = 'knp.minibus.gate_open';

    const GATE_CLOSE = 'knp.minibus.gate_close';
}
