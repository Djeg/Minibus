<?php

namespace spec\Knp\Minibus\Simple;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MinibusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Simple\Minibus');
    }

    function it_is_a_minibus()
    {
        $this->shouldHaveType('Knp\Minibus\Minibus');
    }

    function it_is_an_iterator_aggregation()
    {
        $this->shouldHaveType('IteratorAggregate');
    }

    function it_can_add_and_retrieve_passenger()
    {
        $this->addPassenger('plop', 'some data');
        $this->addPassenger('plip', 'other data');

        $this->getPassengers()->shouldReturn([
            'plop' => 'some data',
            'plip' => 'other data',
        ]);

        $this->getPassenger('plop')->shouldReturn('some data');
        $this->getPassenger('plip')->shouldReturn('other data');
        $this->getPassenger('unexistent', 'default value')->shouldReturn('default value');

        $this->setPassengers(['some' => 'passengers']);

        $this->getPassenger('some')->shouldReturn('passengers');
    }

}
