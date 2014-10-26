<?php

namespace spec\Knp\Minibus\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Minibus;

class StartEventSpec extends ObjectBehavior
{
    function let(Minibus $bus)
    {
        $this->beConstructedWith($bus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Event\StartEvent');
    }

    function it_is_an_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_contains_a_minibus($bus, Minibus $secondBus)
    {
        $this->getMinibus()->shouldReturn($bus);

        $this->setMinibus($secondBus);

        $this->getMinibus()->shouldReturn($secondBus);
    }
}
