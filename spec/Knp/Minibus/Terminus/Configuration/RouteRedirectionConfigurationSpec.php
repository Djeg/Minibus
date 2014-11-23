<?php

namespace spec\Knp\Minibus\Terminus\Configuration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouteRedirectionConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\Configuration\RouteRedirectionConfiguration');
    }

    function it_is_a_configuration()
    {
        $this->shouldHaveType('Symfony\Component\Config\Definition\ConfigurationInterface');
    }

    function it_buld_a_configuration_tree()
    {
        $this->getConfigTreeBuilder()->shouldHaveType('Symfony\Component\Config\Definition\Builder\TreeBuilder');
    }
}
