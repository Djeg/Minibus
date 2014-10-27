<?php

namespace funk\Knp\Minibus\Terminus;

use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Funk\Spec;
use Knp\Minibus\Terminus\TwigTemplateTerminus;
use Symfony\Component\Yaml\Yaml;

class TwigTemplateTerminusFunk implements Spec
{
    function it_can_be_configured()
    {
        $dumper      = new YamlReferenceDumper;
        $twig        = new \Twig_Environment;
        $terminus    = new TwigTemplateTerminus($twig);
        $treeBuilder = new TreeBuilder;
        $rootNode    = $treeBuilder->root('twig_template_terminus');

        $terminus->configure($rootNode);

        expect(Yaml::parse($dumper->dumpNode($treeBuilder->buildTree())))->toReturn([
            'twig_template_terminus' => [
                'template' => null,
                'key'      => ''
            ]
        ]);
    }
}
