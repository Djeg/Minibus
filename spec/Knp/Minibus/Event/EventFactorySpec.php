<?php

namespace spec\Knp\Minibus\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Minibus;
use Knp\Minibus\Event\TerminusEvent;
use Knp\Minibus\Station;
use Knp\Minibus\Event\GateEvent;
use Knp\Minibus\Event\StartEvent;
use Knp\Minibus\Terminus;

class EventFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Event\EventFactory');
    }

    function it_creates_a_start_event(Minibus $bus)
    {
        $this->createStart($bus)->shouldReturnStartEventWith($bus);
    }

    function it_creates_gate_event(Minibus $minibus, Station $station)
    {
        $this->createGate($minibus, $station)->shouldReturnGateEventWith($minibus, $station);
    }

    function it_create_a_terminus_event(Minibus $minibus, Terminus $terminus)
    {
        $this
            ->createTerminus($minibus, $terminus, ['configuration'])
            ->shouldReturnTerminusEventWith($minibus, $terminus, ['configuration'])
        ;
    }

    function getMatchers()
    {
        return [
            'returnTerminusEventWith' => function ($event, $minibus, $terminus, $configuration) {
                if (!$event instanceof TerminusEvent) {
                    return false;
                }

                return $event->getMinibus() === $minibus &&
                    $event->getTerminus() === $terminus &&
                    $event->getConfiguration() === $configuration
                ;
            },
            'returnGateEventWith' => function ($event, $minibus, $station) {
                if (!$event instanceof GateEvent) {
                    return false;
                }

                return $event->getMinibus() === $minibus && $event->getStation() === $station;
            },
            'returnStartEventWith' => function ($event, $minibus) {
                if (!$event instanceof StartEvent) {
                    return false;
                }

                return $event->getMinibus() === $minibus;
            },
        ];
    }
}
