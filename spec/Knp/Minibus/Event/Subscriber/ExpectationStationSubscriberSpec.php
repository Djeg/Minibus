<?php

namespace spec\Knp\Minibus\Event\Subscriber;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Event\GateEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Knp\Minibus\Event\Subscriber\ExpectationStationSubscriber;
use Knp\Minibus\Minibus;
use Knp\Minibus\Expectation\ResolveEnteringPassengers;
use Knp\Minibus\Expectation\ResolveLeavingPassengers;
use Knp\Minibus\Station;

class ExpectationStationSubscriberSpec extends ObjectBehavior
{
    function let(OptionsResolverInterface $resolver)
    {
        $this->beConstructedWith($resolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Event\Subscriber\ExpectationStationSubscriber');
    }

    function it_is_an_event_subscriber()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_subscribe_to_line_events()
    {
        expect(ExpectationStationSubscriber::getSubscribedEvents())->toReturn([
            LineEvents::GATE_OPEN  => 'validateEnteringPassengers',
            LineEvents::GATE_CLOSE => 'validateLeavingPassengers',
            LineEvents::TERMINUS   => 'clearResolver',
        ]);
    }

    function it_validate_entering_passengers_for_a_station(
        GateEvent $event,
        Minibus $minibus,
        ResolveEnteringPassengers $station,
        $resolver
    ) {
        $event->getMinibus()->willReturn($minibus);
        $event->getStation()->willReturn($station);

        $minibus->getPassengers()->willReturn(['some passengers']);

        $station->setEnteringPassengers($resolver)->shouldBeCalled();

        $resolver->resolve(['some passengers'])->willReturn(['validate passenger']);

        $minibus->setPassengers(['validate passenger'])->shouldBeCalled();

        $this->validateEnteringPassengers($event);
    }

    function it_validate_leaving_passengers_for_a_station(
        GateEvent $event,
        Minibus $minibus,
        ResolveLeavingPassengers $station,
        $resolver
    ) {
        $event->getMinibus()->willReturn($minibus);
        $event->getStation()->willReturn($station);

        $minibus->getPassengers()->willReturn(['some passengers']);

        $station->setLeavingPassengers($resolver)->shouldBeCalled();

        $resolver->resolve(['some passengers'])->willReturn(['validated passengers']);

        $minibus->setPassengers(['validated passengers'])->shouldBeCalled();

        $this->validateLeavingPassengers($event);
    }

    function it_add_to_the_resolver_defaults_all_passengers_for_non_supported_station_that_modified_minibus(
        GateEvent $event,
        Minibus $minibus,
        Station $station,
        $resolver
    ) {
        $event->getMinibus()->willReturn($minibus);
        $event->getStation()->willReturn($station);

        $minibus->getPassengers()->willReturn(['some passengers']);

        $resolver->setDefaults(['some passengers'])->shouldBeCalled();
        $resolver->resolve(Argument::any())->shouldNotBeCalled();

        $this->validateEnteringPassengers($event);
    }
}
