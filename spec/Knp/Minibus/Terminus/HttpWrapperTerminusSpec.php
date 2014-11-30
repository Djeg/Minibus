<?php

namespace spec\Knp\Minibus\Terminus;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Terminus;
use Knp\Minibus\Minibus;
use Symfony\Component\HttpFoundation\Response;

class HttpWrapperTerminusSpec extends ObjectBehavior
{
    function let(Terminus $terminus)
    {
        $this->beConstructedWith($terminus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\HttpWrapperTerminus');
    }

    function it_is_a_configurable_terminus()
    {
        $this->shouldHaveType('Knp\Minibus\Configurable\ConfigurableTerminus');
    }

    function it_contains_an_http_wrapper_configuration()
    {
    }

    function it_wrap_a_terminus_into_an_http_response($terminus, Minibus $minibus)
    {
        $terminus->terminate($minibus, Argument::any())->willReturn('final result');

        $options = [
            'status_code' => 200,
            'headers'     => [
                'Content-Type' => 'text/html'
            ]
        ];

        $this
            ->terminate($minibus, $options)
            ->shouldReturnAnHttpResponseWith($options['status_code'], $options['headers'])
        ;
    }

    function getMatchers()
    {
        return [
            'returnAnHttpResponseWith' => function ($response, $statusCode, $headers) {
                if (!is_object($response) or !$response instanceof Response) {
                    return false;
                }

                if ($response->getStatusCode() !== (int)$statusCode) {
                    return false;
                }

                foreach ($headers as $name => $value) {
                    if (!$response->headers->has($name)) {
                        return false;
                    }

                    if ($response->headers->get($name) !== $value) {
                        return false;
                    }
                }

                return true;
            },
        ];
    }
}
