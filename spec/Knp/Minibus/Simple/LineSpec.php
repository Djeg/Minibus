<?php

namespace spec\Knp\Minibus\Simple;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Knp\Minibus\Event\EventFactory;
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Event\StartEvent;
use Knp\Minibus\Event\GateEvent;
use Knp\Minibus\Event\TerminusEvent;

class LineSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher, EventFactory $factory)
    {
        $this->beConstructedWith($dispatcher, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Simple\Line');
    }

    function it_is_a_line()
    {
        $this->shouldHaveType('Knp\Minibus\Line');
    }

    function it_follow_all_the_station_and_dispatch_line_events(
        $dispatcher,
        $factory,
        StartEvent $startEvent,
        GateEvent $gateEvent,
        TerminusEvent $terminusEvent,
        Minibus $minibus,
        Station $station1,
        Station $station2
    ) {
        $factory->createStart($minibus)->willReturn($startEvent);
        $dispatcher->dispatch(LineEvents::START, $startEvent)->shouldBeCalled();
        $startEvent->getMinibus()->willReturn($minibus);

        $this->addStation($station1);
        $this->addStation($station2);

        $factory->createGate($minibus, $station1)->willReturn($gateEvent);
        $factory->createGate($minibus, $station2)->willReturn($gateEvent);
        $dispatcher->dispatch(LineEvents::GATE_OPEN, $gateEvent)->shouldBeCalled();

        $station1->handle($minibus)->shouldBeCalled();
        $station2->handle($minibus)->shouldBeCalled();

        $dispatcher->dispatch(LineEvents::GATE_CLOSE, $gateEvent)->shouldBeCalled();

        $factory->createTerminus($minibus)->willReturn($terminusEvent);
        $dispatcher->dispatch(LineEvents::TERMINUS, $terminusEvent)->shouldBeCalled();

        $terminusEvent->getFinalData()->willReturn('final data');

        $this->follow($minibus)->shouldReturn('final data');
    }
}
