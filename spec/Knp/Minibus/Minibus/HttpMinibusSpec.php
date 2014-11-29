<?php

namespace spec\Knp\Minibus\Minibus;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Minibus;

class HttpMinibusSpec extends ObjectBehavior
{
    function let(Request $request, Response $response)
    {
        $this->beConstructedWith($request, $response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Minibus\HttpMinibus');
    }

    function it_is_a_minibus()
    {
        $this->shouldHaveType('Knp\Minibus\Minibus');
    }

    function it_contains_passenger_and_an_http_request_and_a_response($request, $response)
    {
        $this->addPassenger('plop', 'plip');
        $this->getPassenger('plop')->shouldReturn('plip');
        $this->getPassengers()->shouldReturn(['plop' => 'plip']);
        $this->hasPassenger('plop')->shouldReturn(true);
        $this->removePassenger('plop');
        $this->getPassenger('plop', 'default')->shouldReturn('default');

        $this->getRequest()->shouldReturn($request);
        $this->getResponse()->shouldReturn($response);
    }

    function it_wrapp_and_use_a_real_minibus($request, $response, Minibus $minibus)
    {
        $this->beConstructedWith($request, $response, $minibus);

        $minibus->addPassenger('test', 'value')->shouldBeCalled();
        $this->addPassenger('test', 'value');

        $minibus->getPassenger('key', 'default')->shouldBeCalled();
        $this->getPassenger('key', 'default');

        $minibus->hasPassenger('some')->shouldBeCalled();
        $this->hasPassenger('some');

        $minibus->removePassenger('key')->shouldBeCalled();
        $this->removePassenger('key');

        $minibus->getPassengers()->shouldBeCalled();
        $this->getPassengers();
    }
}
