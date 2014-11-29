<?php

namespace spec\Knp\Minibus\Terminus;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Config\Definition\Builder\NodeParentInterface;
use Knp\Minibus\Minibus;

class TwigTemplateTerminusSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twig)
    {
        $this->beConstructedWith($twig);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\TwigTemplateTerminus');
    }

    function it_is_a_configurable_terminus()
    {
        $this->shouldHaveType('Knp\Minibus\Configurable\ConfigurableTerminus');
    }

    function it_terminates_by_returning_a_template_result(Minibus $minibus, $twig)
    {
        $twig->render('template.twig', ['minibus' => ['minibus content']])->willReturn('template content');

        $minibus->getPassengers()->willReturn(['minibus content']);

        $this->terminate($minibus, [
            'template' => 'template.twig',
            'key'      => 'minibus',
            'defaults' => []
        ]);
    }

    function it_can_return_the_minibus_passengers_directly_as_a_twig_context(Minibus $minibus, $twig)
    {
        $twig->render('template.twig', ['minibus content'])->willReturn('template content');

        $minibus->getPassengers()->willReturn(['minibus content']);

        $this->terminate($minibus, [
            'template' => 'template.twig',
            'key'      => '',
            'defaults' => []
        ]);
    }

    function it_contains_twig_template_configuration()
    {
        $this->getConfiguration()->shouldHaveType('Knp\Minibus\Terminus\Configuration\TwigTemplateTerminusConfiguration');
    }
}
