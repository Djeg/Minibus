<?php

namespace spec\Knp\Minibus\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Minibus;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResponseBuilderSpec extends ObjectBehavior
{
    function let(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'http_status_code_passenger' => '_http_status_code',
            'http_headers_passenger'     => '_http_headers',
        ])->shouldBeCalled()->willReturn($resolver);
        $resolver->setAllowedTypes([
            'http_status_code_passenger' => 'string',
            'http_headers_passenger'     => 'string',
        ])->shouldBeCalled();
        $resolver->resolve([
            'http_status_code_passenger' => '_http_status_code',
            'http_headers_passenger'     => '_http_headers'
        ])->shouldBeCalled()->willReturn([
            'http_status_code_passenger' => '_http_status_code',
            'http_headers_passenger'     => '_http_headers'
        ]);

        $this->beConstructedWith([
            'http_status_code_passenger' => '_http_status_code',
            'http_headers_passenger'     => '_http_headers'
        ], $resolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Http\ResponseBuilder');
    }

    function it_create_a_response_with_the_headers_status_and_content(Minibus $minibus)
    {
        $minibus->getPassenger('_http_status_code', null)->willReturn(200);
        $minibus->getPassenger('_http_headers', null)->willReturn(['some' => 'headers']);

        $this->build($minibus)->shouldReturnResponseWith(null, 200, ['some' => 'headers']);

        $minibus->getPassenger('_http_status_code', null)->willReturn(304);
        $minibus->getPassenger('_http_headers', null)->willReturn(['other' => 'headers']);

        $this->build($minibus)->shouldReturnResponseWith(null, 304, ['other' => 'headers']);
    }

    function getMatchers()
    {
        return [
            'returnResponseWith' => function ($response, $content, $status, $headers) {
                $a = $response instanceof Response;
                $b = $response->getStatusCode() === $status;

                $c = true;
                foreach ($headers as $name => $value) {
                    if (!$response->headers->has($name) ||
                        $response->headers->get($name) !== $value) {
                        $c = false;
                    }
                }

                return $a && $b && $c;
            }
        ];
    }
}
