<?php

namespace spec\Knp\Minibus\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TerminusAlwaysExistsExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Exception\TerminusAlwaysExistsException');
    }

    function it_is_an_exception()
    {
        $this->shouldHaveType('Exception');
    }
}
