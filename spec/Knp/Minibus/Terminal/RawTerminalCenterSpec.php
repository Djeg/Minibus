<?php

namespace spec\Knp\Minibus\Terminal;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Minibus;
use Knp\Minibus\Terminus\ConfigurableTerminus;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\NodeInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class RawTerminalCenterSpec extends ObjectBehavior
{
    function let(Processor $processor, TreeBuilder $builder)
    {
        $this->beConstructedWith($processor, $builder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Terminal\RawTerminalCenter');
    }

    function it_is_a_terminal_center()
    {
        $this->shouldHaveType('Knp\Minibus\Terminal\TerminalCenter');
    }

    function it_contains_terminus_that_can_be_resolved(Minibus $minibus, Terminus $terminus)
    {
        $this->addTerminus('some_name', $terminus);

        $terminus->terminate($minibus, ['terminus configuration'])->shouldBeCalled()->willReturn('terminus result');

        $this
            ->resolve($minibus, 'some_name', ['terminus configuration'])
            ->shouldReturn('terminus result')
        ;

        $this
            ->shouldThrow('Knp\Minibus\Exception\TerminusNotFoundException')
            ->duringResolve($minibus, 'unexistent_terminus', [])
        ;
    }

    function it_resolve_terminus_configuration_for_configurable_terminus(
        ConfigurableTerminus $configurableTerminus,
        Minibus $minibus,
        $processor,
        $builder,
        ArrayNodeDefinition $rootNode,
        NodeInterface $tree
    ) {
        $this->addTerminus('configurable_terminus', $configurableTerminus);
        $builder->root('configurable_terminus')->willReturn($rootNode);
        $configurableTerminus->configure($rootNode)->shouldBeCalled();
        $builder->buildTree()->willReturn($tree);
        $processor->process($tree, [['some_configuration']])->shouldBeCalled()->willReturn(['processed configuration']);

        $configurableTerminus->terminate($minibus, ['processed configuration'])->shouldBeCalled()->willReturn('terminus result');

        $this->resolve($minibus, 'configurable_terminus', ['some_configuration'])->shouldReturn('terminus result');
    }

    function it_can_not_contains_the_same_terminus_name_twice(Terminus $terminus1, Terminus $terminus2)
    {
        $this->addTerminus('some_name', $terminus1);

        $this
            ->shouldThrow('Knp\Minibus\Exception\TerminusAlwaysExistsException')
            ->duringAddTerminus('some_name', $terminus2)
        ;

        $this
            ->shouldThrow('Knp\Minibus\Exception\TerminusAlwaysExistsException')
            ->duringAddTerminus('some_name', $terminus1)
        ;
    }
}
