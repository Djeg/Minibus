<?php

namespace funk\Knp\Minibus;

use Funk\Spec;
use Knp\Minibus\Minibus\Minibus;
use Knp\Minibus\Line\Line;
use JMS\Serializer\SerializerBuilder;
use example\Knp\Minibus\Station\OtherBasicStation;
use example\Knp\Minibus\Station\BasicStation;
use Knp\Minibus\Terminus\JmsSerializerTerminus;
use Knp\Minibus\Terminus\TwigTemplateTerminus;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Terminus\HttpWrapperTerminus;

class TerminusFunk implements Spec
{
    function it_can_serialize_minibus_passenger()
    {
        $minibus  = new Minibus;
        $line     = new Line;
        $terminus = new JmsSerializerTerminus(SerializerBuilder::create()->build());
        $station1 = new BasicStation;
        $station2 = new OtherBasicStation;

        $line
            ->addStation($station1)
            ->addStation($station2)
            ->setTerminus($terminus, [
                'format' => 'json'
            ])
        ;

        expect($line->lead($minibus))->toBe('{"basic":true,"other_basic":true}');
    }

    function it_can_display_a_twig_template()
    {
        $minibus  = new Minibus;
        $line     = new Line;
        $terminus = new TwigTemplateTerminus(new \Twig_Environment(new \Twig_Loader_String));
        $station1 = new BasicStation;
        $station2 = new OtherBasicStation;

        $template = 'Basic is {% if basic %}OK{% else %}NOT OK{% endif %} and Other basic is {% if other_basic %}OK{% else %}NOT OK{% endif %}';

        $line
            ->addStation($station1)
            ->addStation($station2)
            ->setTerminus($terminus, [
                'template' => $template
            ])
        ;

        expect($line->lead($minibus))->toBe('Basic is OK and Other basic is OK');
    }

    function it_can_wrap_any_terminus_into_a_response()
    {
        $minibus         = new Minibus;
        $line            = new Line;
        $terminus        = new TwigTemplateTerminus(new \Twig_Environment(new \Twig_Loader_String));
        $station1        = new BasicStation;
        $station2        = new OtherBasicStation;
        $template        = 'Basic is {% if basic %}OK{% else %}NOT OK{% endif %} and Other basic is {% if other_basic %}OK{% else %}NOT OK{% endif %}';
        $terminusWrapper = new HttpWrapperTerminus($terminus);

        $line
            ->addStation($station1)
            ->addStation($station2)
            ->setTerminus($terminusWrapper, [
                'template' => $template,
                'headers'  => [
                    'Content-Type' => 'text/html'
                ]
            ])
        ;

        $response = $line->lead($minibus);

        expect($response instanceof Response)->toBe(true);
        expect($response->getContent())->toBe('Basic is OK and Other basic is OK');
    }
}
