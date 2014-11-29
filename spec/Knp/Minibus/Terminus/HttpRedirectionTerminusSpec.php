<?php

namespace spec\Knp\Minibus\Terminus;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Knp\Minibus\Minibus;

class HttpRedirectionTerminusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\HttpRedirectionTerminus');
    }

    function it_is_a_configurable_terminus()
    {
        $this->shouldHaveType('Knp\Minibus\Configurable\ConfigurableTerminus');
    }

    function it_redirect_to_the_given_path(Minibus $minibus)
    {
        $this
            ->terminate($minibus, ['target' => 'google.fr'])
            ->shouldReturnRedirectionTo('google.fr')
        ;
    }

    function it_contains_a_configuration()
    {
        $this->getConfiguration()->shouldHaveType('Knp\Minibus\Terminus\Configuration\HttpRedirectionConfiguration');
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
