<?php

namespace spec\Knp\Minibus\Event\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Terminal\TerminalCenter;
use Knp\Minibus\Event\TerminusEvent;
use Knp\Minibus\Minibus;

class TerminusListenerSpec extends ObjectBehavior
{
    function let(TerminalCenter $center)
    {
        $this->beConstructedWith($center, '_terminus', '_terminus_config');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Event\Listener\TerminusListener');
    }

    function it_supports_only_minibus_with_terminus_passenger(
        TerminusEvent $event,
        Minibus $minibus,
        $center
    ) {
        $event->getMinibus()->willReturn($minibus);
        $minibus->getPassenger('_terminus')->willReturn(null);

        $center->resolve(Argument::cetera())->shouldNotBeCalled();
        $event->setFinalData(Argument::cetera())->shouldNotBeCalled();

        $this->handleTerminus($event);
    }

    function it_resolves_minibus_terminal_passenger_and_stores_it_inside_terminal_event_final_data( 
        TerminusEvent $event,
        Minibus $minibus,
        $center
    ) {
        $event->getMinibus()->willReturn($minibus);
        $minibus->getPassenger('_terminus')->willReturn('terminus_name');
        $minibus->getPassenger('_terminus_config', [])->willReturn(['terminus config']);

        $center->resolve($minibus, 'terminus_name', ['terminus config'])->willReturn('terminus data');

        $event->setFinalData('terminus data')->shouldBeCalled();

        $this->handleTerminus($event);
    }
}
