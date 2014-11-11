<?php

namespace funk\Knp\Minibus;

use Funk\Spec;
use Knp\Minibus\Simple\Line;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Knp\Minibus\Terminal\RawTerminalCenter;
use Knp\Minibus\Terminal\HttpResponseTerminalCenter;
use Knp\Minibus\Event\Listener\TerminusListener;
use Knp\Minibus\Event\LineEvents;
use example\Knp\Minibus\Station\NameStation;
use Knp\Minibus\Terminus\JmsSerializerTerminus;
use Knp\Minibus\Terminus\TwigTemplateTerminus;
use JMS\Serializer\SerializerBuilder;
use Knp\Minibus\Simple\Minibus;
use Knp\Minibus\Http\HttpMinibus;
use Symfony\Component\HttpFoundation\Request;

class HttpLineFunk implements Spec
{
    function it_transform_any_terminus_into_http_response()
    {
        $terminalCenter = new HttpResponseTerminalCenter(new RawTerminalCenter);

        $terminalListener = new TerminusListener($terminalCenter);
        $dispatcher = new EventDispatcher;
        $dispatcher->addListener(LineEvents::TERMINUS, [$terminalListener, 'handleTerminus']);

        $busLine = new Line($dispatcher);

        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__.'/../../../example/Resources/templates'));

        $terminalCenter->addTerminus('json', new JmsSerializerTerminus(SerializerBuilder::create()->build()));
        $terminalCenter->addTerminus('twig', new TwigTemplateTerminus($twig));

        $busLine->addStation(new NameStation);

        $minibus = new HttpMinibus(new Request);
        $minibus->addPassenger('_terminus', 'json');

        $response = $busLine->lead($minibus);

        expect($response->getContent())->toReturn('{"name":"minibus"}');
        expect($response->headers->get('content-type'))->toReturn('application/json');
        expect($response->getStatusCode())->toReturn(200);

        $minibus = new HttpMinibus(new Request);
        $minibus->addPassenger('_terminus', 'twig');
        $minibus->addPassenger('_terminus_config', [
            'template' => 'test.html.twig'
        ]);

        $response = $busLine->lead($minibus);

        expect($response->getContent())->toReturn("<h1>minibus</h1>\n");
        expect($response->getStatusCode())->toReturn(200);
    }
}
