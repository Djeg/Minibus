<?php

namespace Knp\Minibus\Event\Listener;

use Knp\Minibus\Terminal\TerminalCenter;
use Knp\Minibus\Event\TerminusEvent;

/**
 * This listener can be plugged to the dispatcher send to a line in order
 * to transform minibus passenger into a corect final data, like an http response ;).
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class TerminusListener
{
    /**
     * @var TerminalCenter $center
     */
    private $center;

    /**
     * @var string $key
     */
    private $key;

    /**
     * @var string $configKey
     */
    private $configKey;

    /**
     * @param TerminalCenter $center
     * @param string         $key
     * @param string         $configKey
     */
    public function __construct(
        TerminalCenter $center,
        $key = '_terminus',
        $configKey = '_terminus_config'
    ) {
        $this->center    = $center;
        $this->key       = $key;
        $this->configKey = $configKey;
    }

    /**
     * @param TerminusEvent $event
     */
    public function handleTerminus(TerminusEvent $event)
    {
        $minibus = $event->getMinibus();

        if (null === $minibus->getPassenger($this->key)) {
            return;
        }

        $terminus      = $minibus->getPassenger($this->key);
        $configuration = $minibus->getPassenger($this->configKey, []);

        $event->setFinalData($this->center->resolve($minibus, $terminus, $configuration));
    }
}
