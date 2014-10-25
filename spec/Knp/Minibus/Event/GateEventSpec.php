<?php

namespace spec\Knp\Minibus\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Station;
use Knp\Minibus\Minibus;

class GateEventSpec extends ObjectBehavior
{
    function let(Station $station, Minibus $minibus)
    {
        $this->beConstructedWith($minibus, $station); 
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Event\GateEvent');
    }

    function it_is_an_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_contains_a_station_and_a_minibus($station, $minibus)
    {
        $this->getStation()->shouldReturn($station);
        $this->getMinibus()->shouldReturn($minibus);
    }
}
