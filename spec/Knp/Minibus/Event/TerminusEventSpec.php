<?php

namespace spec\Knp\Minibus\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Minibus;

class TerminusEventSpec extends ObjectBehavior
{
    function let(Minibus $minibus)
    {
        $this->beConstructedWith($minibus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Event\TerminusEvent');
    }

    function it_is_an_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_contains_a_minibus_and_a_final_data($minibus)
    {
        $this->getMinibus()->shouldReturn($minibus);
        $this->setFinalData('Final data');

        $this->getFinalData()->shouldReturn('Final data');
    }
}
