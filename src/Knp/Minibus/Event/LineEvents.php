<?php

namespace Knp\Minibus\Event;

/**
 * All the events dispatched by a, line.
 */
abstract class LineEvents
{
    const START      = 'knp_minibus.start';

    const TERMINUS   = 'knp_minibus.terminus';

    const GATE_OPEN  = 'knp_minibus.gate_open';

    const GATE_CLOSE = 'knp_minibus.gate_close';
}
