<?php

namespace funk\Knp\Minibus\Terminus;

use Funk\Spec;
use JMS\Serializer\SerializerBuilder;
use Knp\Minibus\Terminus\JmsSerializerTerminus;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;

class JmsSerializerTerminusFunk implements Spec
{
    function it_can_be_configure()
    {
        $dumper      = new YamlReferenceDumper;
        $terminus    = new JmsSerializerTerminus(SerializerBuilder::create()->build());
        $treeBuilder = new TreeBuilder;
        $rootNode    = $treeBuilder->root('jms_serializer');

        $terminus->configure($rootNode);

        expect(Yaml::parse($dumper->dumpNode($treeBuilder->buildTree())))->toReturn([
            'jms_serializer' => [
                'format'                 => 'json',
                'version'                => null,
                'groups'                 => [],
                'enable_max_depth_check' => false
            ]
        ]);
    }
}
