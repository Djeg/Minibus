<?php

namespace spec\Knp\Minibus\Simple;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Knp\Minibus\Event\EventFactory;
use Symfony\Component\Config\Definition\Processor;
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;
use Knp\Minibus\Event\StartEvent;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Event\GateEvent;
use Knp\Minibus\Event\TerminusEvent;
use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Config\ConfigurableStation;
use Knp\Minibus\Config\ConfigurableTerminus;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class LineSpec extends ObjectBehavior
{
    function let(
        EventDispatcherInterface $dispatcher,
        EventFactory             $eventFactory,
        Processor                $processor
    ) {
        $this->beConstructedWith($dispatcher, null, $eventFactory, $processor);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Simple\Line');
    }

    function it_is_a_line()
    {
        $this->shouldHaveType('Knp\Minibus\Line');
    }

    function it_contain_an_event_dispatcher($dispatcher)
    {
        $this->getDispatcher()->shouldReturn($dispatcher);
    }

    function it_lead_a_minibus_thrue_stations_and_raised_events(
        $dispatcher,
        $eventFactory,
        $processor,
        Station $station,
        Minibus $minibus,
        StartEvent $startEvent,
        GateEvent $gateEvent,
        TerminusEvent $terminusEvent
    ) {
        $this->addStation($station);

        $eventFactory->createStart($minibus)->willReturn($startEvent);
        $dispatcher->dispatch(LineEvents::START, $startEvent)->shouldBeCalled();
        $startEvent->getMinibus()->willReturn($minibus);

        $eventFactory->createGate($minibus, $station)->willReturn($gateEvent);
        $dispatcher->dispatch(LineEvents::GATE_OPEN, $gateEvent)->shouldBeCalled();

        $station->handle($minibus, [])->shouldBeCalled();

        $dispatcher->dispatch(LineEvents::GATE_CLOSE, $gateEvent)->shouldBeCalled();

        $eventFactory->createTerminus($minibus, null, [])->willReturn($terminusEvent);
        $dispatcher->dispatch(LineEvents::TERMINUS, $terminusEvent)->shouldBeCalled();

        $terminusEvent->getTerminus()->willReturn(null);
        $terminusEvent->getConfiguration()->willReturn([]);

        $this->lead($minibus)->shouldReturn($minibus);
    }

    function it_supports_a_terminus(
        $dispatcher,
        $eventFactory,
        $processor,
        Station $station,
        Minibus $minibus,
        StartEvent $startEvent,
        GateEvent $gateEvent,
        TerminusEvent $terminusEvent,
        Terminus $terminus
    ) {
        $this->addStation($station);
        $this->setTerminus($terminus);

        $eventFactory->createStart($minibus)->willReturn($startEvent);
        $dispatcher->dispatch(LineEvents::START, $startEvent)->shouldBeCalled();
        $startEvent->getMinibus()->willReturn($minibus);

        $eventFactory->createGate($minibus, $station)->willReturn($gateEvent);
        $dispatcher->dispatch(LineEvents::GATE_OPEN, $gateEvent)->shouldBeCalled();

        $station->handle($minibus, [])->shouldBeCalled();

        $dispatcher->dispatch(LineEvents::GATE_CLOSE, $gateEvent)->shouldBeCalled();

        $eventFactory->createTerminus($minibus, $terminus, [])->willReturn($terminusEvent);
        $dispatcher->dispatch(LineEvents::TERMINUS, $terminusEvent)->shouldBeCalled();

        $terminusEvent->getTerminus()->willReturn($terminus);
        $terminusEvent->getConfiguration()->willReturn([]);

        $terminus->terminate($minibus, [])->willReturn('Final result');

        $this->lead($minibus)->shouldReturn('Final result');
    }

    function it_can_configure_terminus_and_stations(
        $dispatcher,
        $eventFactory,
        $processor,
        ConfigurableStation $station,
        ConfigurationInterface $stationConfiguration,
        Minibus $minibus,
        StartEvent $startEvent,
        GateEvent $gateEvent,
        TerminusEvent $terminusEvent,
        ConfigurableTerminus $terminus,
        ConfigurationInterface $terminusConfiguration
    ) {
        $this->addStation($station, ['raw station configuration']);
        $this->setTerminus($terminus, ['raw terminus configuration']);

        $eventFactory->createStart($minibus)->willReturn($startEvent);
        $dispatcher->dispatch(LineEvents::START, $startEvent)->shouldBeCalled();
        $startEvent->getMinibus()->willReturn($minibus);

        $eventFactory->createGate($minibus, $station)->willReturn($gateEvent);
        $dispatcher->dispatch(LineEvents::GATE_OPEN, $gateEvent)->shouldBeCalled();

        $station->getConfiguration()->willReturn($stationConfiguration);
        $processor
            ->processConfiguration($stationConfiguration, [['raw station configuration']])
            ->willReturn(['Parsed station configuration'])
        ;

        $station->handle($minibus, ['Parsed station configuration'])->shouldBeCalled();

        $dispatcher->dispatch(LineEvents::GATE_CLOSE, $gateEvent)->shouldBeCalled();

        $terminus->getConfiguration()->willReturn($terminusConfiguration);
        $processor
            ->processConfiguration($terminusConfiguration, [['raw terminus configuration']])
            ->willReturn(['parsed terminus configuration'])
        ;

        $eventFactory->createTerminus($minibus, $terminus, ['parsed terminus configuration'])->willReturn($terminusEvent);
        $dispatcher->dispatch(LineEvents::TERMINUS, $terminusEvent)->shouldBeCalled();

        $terminusEvent->getTerminus()->willReturn($terminus);
        $terminusEvent->getConfiguration()->willReturn(['parsed terminus configuration']);

        $terminus->terminate($minibus, ['parsed terminus configuration'])->willReturn('Final result');

        $this->lead($minibus)->shouldReturn('Final result');
    }
}
