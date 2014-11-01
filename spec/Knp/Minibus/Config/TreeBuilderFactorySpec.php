<?php

namespace spec\Knp\Minibus\Config;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TreeBuilderFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Config\TreeBuilderFactory');
    }

    function it_create_a_new_tree_builder_instance()
    {
        $this->create()->shouldHaveType('Symfony\Component\Config\Definition\Builder\TreeBuilder');
    }
}
