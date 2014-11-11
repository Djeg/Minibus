<?php

namespace spec\Knp\Minibus\Terminal;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Minibus;
use Knp\Minibus\Terminal\TerminalCenter;
use Knp\Minibus\Terminus\Terminus;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Http\HttpMinibus;

class HttpResponseTerminalCenterSpec extends ObjectBehavior
{
    function let(TerminalCenter $center)
    {
        $this->beConstructedWith($center);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminal\HttpResponseTerminalCenter');
    }

    function it_should_be_a_terminal_center()
    {
        $this->shouldHaveType('Knp\Minibus\Terminal\TerminalCenter');
    }

    function it_use_the_wrapped_terminal_center_to_add_terminus($center, Terminus $terminus)
    {
        $center->addTerminus('some name', $terminus)->shouldBeCalled();

        $this->addTerminus('some name', $terminus);
    }

    function it_resolve_any_minibus_into_an_http_response(HttpMinibus $minibus, Response $response, $center)
    {
        $minibus->getResponse()->shouldBeCalled()->willReturn($response);
        $response->setContent('content')->shouldBeCalled();

        $center->resolve($minibus, 'some terminus', ['configuration'])->willReturn('content');

        $this->resolve($minibus, 'some terminus', ['configuration'])->shouldReturn($response);
    }

    function it_only_supports_http_minibus(Minibus $minibus)
    {
        $this->shouldThrow('InvalidArgumentException')->duringResolve($minibus, 'some terminus', ['some configuration']);
    }
}
