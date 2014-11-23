<?php

namespace spec\Knp\Minibus\Terminus;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Knp\Minibus\Minibus;

class RouteRedirectionTerminusSpec extends ObjectBehavior
{
    function let(UrlGeneratorInterface $generator)
    {
        $this->beConstructedWith($generator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\RouteRedirectionTerminus');
    }

    function it_is_a_configurable_terminus()
    {
        $this->shouldHaveType('Knp\Minibus\Config\ConfigurableTerminus');
    }

    function it_contains_the_configuration()
    {
        $this->getConfiguration()->shouldHaveType('Knp\Minibus\Terminus\Configuration\RouteRedirectionConfiguration');
    }

    function it_return_a_redirection_to_a_route($generator, Minibus $minibus)
    {
        $generator->generate('some_route', ['id' => 10], false)->willReturn('/path/to/10');
        $minibus->getPassenger('some_id', null)->willReturn(10);

        $this->terminate($minibus, [
            'route' => 'some_route',
            'parameters' => [
                'id' => 'some_id'
            ],
            'type' => 'absolute'
        ])->shouldReturnRedirectionTo('/path/to/10');
    }

    function it_throw_exception_when_trying_to_resolve_a_non_existent_passenger(
        $generator,
        Minibus $minibus
    ) {
        $minibus->getPassenger('plop', null)->willReturn(null);

        $this
            ->shouldThrow('Knp\Minibus\Exception\MissingPassengerException')
            ->duringTerminate($minibus, [
                'route' => 'some_route',
                'parameters' => [
                    'id' => 'plop'
                ],
                'type' => 'absolute'
            ])
        ;
    }

    function getMatchers()
    {
        return [
            'returnRedirectionTo' => function ($redirection, $to) {
                return $redirection instanceof RedirectResponse &&
                    $redirection->getTargetUrl() === $to
                ;
            }
        ];
    }
}
