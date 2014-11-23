<?php

namespace spec\Knp\Minibus\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MissingPassengerExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Exception\MissingPassengerException');
    }

    function it_is_an_exception()
    {
        $this->shouldHaveType('Exception');
    }
}
