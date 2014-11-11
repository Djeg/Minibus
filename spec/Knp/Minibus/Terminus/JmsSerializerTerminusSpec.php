<?php

namespace spec\Knp\Minibus\Terminus;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use JMS\Serializer\Serializer;
use Knp\Minibus\Minibus;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Http\HttpMinibus;

class JmsSerializerTerminusSpec extends ObjectBehavior
{
    function let(Serializer $serializer, SerializationContext $context)
    {
        $this->beConstructedWith($serializer, $context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\JmsSerializerTerminus');
    }

    function it_is_a_configurable_terminus()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\ConfigurableTerminus');
    }

    function it_should_serialize_the_minibus_passengers_and_set_http_headers(
        HttpMinibus $minibus,
        $serializer,
        $context,
        Response $response,
        HeaderBag $headers
    ) {
        $minibus->getPassengers()->willReturn(['passengers']);
        $serializer->serialize(['passengers'], 'json', $context)->willReturn('["passengers"]');
        $minibus->getResponse()->willReturn($response);
        $response->headers = $headers;
        $headers->set('Content-Type', 'application/json')->shouldBeCalled();

        $this->terminate($minibus, [
            'format'                 => 'json',
            'version'                => null,
            'groups'                 => null,
            'enable_max_depth_check' => false,
        ])->shouldReturn('["passengers"]');

        $context->setVersion(2)->shouldBeCalled();

        $this->terminate($minibus, [
            'format'                 => 'json',
            'version'                => 2,
            'groups'                 => null,
            'enable_max_depth_check' => false,
        ])->shouldReturn('["passengers"]');

        $context->setGroups(['a', 'b'])->shouldBeCalled();

        $this->terminate($minibus, [
            'format'                 => 'json',
            'version'                => 2,
            'groups'                 => ['a', 'b'],
            'enable_max_depth_check' => false,
        ])->shouldReturn('["passengers"]');

        $context->enableMaxDepthChecks()->shouldBeCalled();

        $this->terminate($minibus, [
            'format'                 => 'json',
            'version'                => 2,
            'groups'                 => ['a', 'b'],
            'enable_max_depth_check' => true,
        ])->shouldReturn('["passengers"]');
    }
}
