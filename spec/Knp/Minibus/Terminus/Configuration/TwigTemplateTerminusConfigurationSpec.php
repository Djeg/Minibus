<?php

namespace spec\Knp\Minibus\Terminus\Configuration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TwigTemplateTerminusConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\Configuration\TwigTemplateTerminusConfiguration');
    }

    function it_is_a_configuration()
    {
        $this->shouldHaveType('Symfony\Component\Config\Definition\ConfigurationInterface');
    }

    function it_return_configuration_tree_builder()
    {
        $this->getConfigTreeBuilder()->shouldHaveType('Symfony\Component\Config\Definition\Builder\TreeBuilder');
    }
}
