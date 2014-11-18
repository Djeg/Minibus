<?php

namespace spec\Knp\Minibus\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Minibus;
use Knp\Minibus\Terminus\Terminus;

class TerminusEventSpec extends ObjectBehavior
{
    function let(Minibus $minibus, Terminus $terminus)
    {
        $this->beConstructedWith($minibus, $terminus, ['terminus configuration']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Event\TerminusEvent');
    }

    function it_is_an_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_contains_a_minibus_a_terminus_and_some_terminus_configuration(
        $minibus,
        $terminus,
        Terminus $newTerminus
    ) {
        $this->getMinibus()->shouldReturn($minibus);

        $this->getTerminus()->shouldReturn($terminus);
        $this->setTerminus($newTerminus);
        $this->getTerminus()->shouldReturn($newTerminus);

        $this->getConfiguration()->shouldReturn(['terminus configuration']);
        $this->setConfiguration(['an other configuration']);
        $this->getConfiguration()->shouldReturn(['an other configuration']);
    }
}
