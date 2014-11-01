<?php

namespace spec\Knp\Minibus\Terminal;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Minibus;
use Knp\Minibus\Terminal\TerminalCenter;
use Knp\Minibus\Terminus\Terminus;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Http\ResponseBuilder;

class HttpResponseTerminalCenterSpec extends ObjectBehavior
{
    function let(TerminalCenter $center, ResponseBuilder $builder)
    {
        $this->beConstructedWith($center, $builder);
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

    function it_resolve_any_minibus_into_an_http_response(Minibus $minibus, Response $response, $center, $builder)
    {
        $builder->build($minibus)->shouldBeCalled()->willReturn($response);
        $response->setContent('content')->shouldBeCalled();

        $center->resolve($minibus, 'some terminus', ['configuration'])->willReturn('content');

        $this->resolve($minibus, 'some terminus', ['configuration'])->shouldReturn($response);
    }
}
