<?php

namespace spec\Knp\Minibus\Terminus\Configuration;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;

class HttpWrapperConfigurationSpec extends ObjectBehavior
{
    function let(ConfigurationInterface $configuration)
    {
        $this->beConstructedWith($configuration);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminus\Configuration\HttpWrapperConfiguration');
    }

    function it_is_a_configuration()
    {
        $this->shouldHaveType('Symfony\Component\Config\Definition\ConfigurationInterface');
    }

    function it_wrap_an_existing_configuration($configuration)
    {
        $treeBuilder = new TreeBuilder;
        $treeBuilder->root('foo');
        $configuration->getConfigTreeBuilder()->willReturn($treeBuilder);

        $this->getConfigTreeBuilder()->shouldReturn($treeBuilder);
    }
}
