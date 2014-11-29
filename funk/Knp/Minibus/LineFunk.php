<?php

namespace funk\Knp\Minibus;

use Funk\Spec;
use example\Knp\Minibus\Station\BasicStation;
use Knp\Minibus\Line\Line;
use Knp\Minibus\Minibus\Minibus;
use example\Knp\Minibus\Station\OtherBasicStation;
use example\Knp\Minibus\Terminus\UselessTerminus;
use example\Knp\Minibus\Station\SomeConfigurableStation;
use example\Knp\Minibus\Terminus\SomeConfigurableTerminus;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Event\StartEvent;
use Knp\Minibus\Event\GateEvent;
use Knp\Minibus\Event\TerminusEvent;
use example\Knp\Minibus\Station\ResolvableEnteringStation;
use example\Knp\Minibus\Station\ResolvableEnteringAndLeavingStation;
use Knp\Minibus\Event\Subscriber\ExpectationStationSubscriber;
use example\Knp\Minibus\Station\ResolvableLeavingStation;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

class LineFunk implements Spec
{
    function it_handle_a_minibus_with_station()
    {
        $station1 = new BasicStation;
        $station2 = new OtherBasicStation;
        $minibus  = new Minibus;
        $line     = new Line;

        $line
            ->addStation($station1)
            ->addStation($station2)
        ;

        expect($line->lead($minibus))->toBe($minibus);
        expect($minibus->getPassenger('basic'))->toBe(true);
        expect($minibus->getPassenger('other_basic'))->toBe(true);
    }

    function it_accept_terminus()
    {
        $station1 = new BasicStation;
        $station2 = new OtherBasicStation;
        $minibus  = new Minibus;
        $terminus = new UselessTerminus;
        $line     = new Line;

        $line->setTerminus($terminus);

        $line
            ->addStation($station1)
            ->addStation($station2)
        ;

        expect($line->lead($minibus))->toBe('useless');
        expect($minibus->getPassenger('basic'))->toBe(true);
        expect($minibus->getPassenger('other_basic'))->toBe(true);
    }

    function it_handle_station_and_terminus_configuration()
    {
        $station  = new SomeConfigurableStation;
        $minibus  = new Minibus;
        $terminus = new SomeConfigurableTerminus;
        $line     = new Line;

        $line->setTerminus($terminus, [
            'must_return' => 'test'
        ]);

        $line->addStation($station, ['plop' => 'something']);

        expect($line->lead($minibus))->toBe('test');
        expect($minibus->getPassenger('plop'))->toBe('something');
    }

    function it_raise_events()
    {
        $station1    = new BasicStation;
        $station2    = new OtherBasicStation;
        $minibus     = new Minibus;
        $line        = new Line;
        $onStart     = false;
        $onGateOpen  = false;
        $onGateClose = false;
        $onTerminus  = false;

        $line
            ->addStation($station1)
            ->addStation($station2)
        ;

        $line->getDispatcher()->addListener(LineEvents::START, function (StartEvent $event) use (&$onStart) {
            $onStart = true;
        });
        $line->getDispatcher()->addListener(LineEvents::GATE_OPEN, function (GateEvent $event) use (&$onGateOpen) {
            $onGateOpen = true;
        });
        $line->getDispatcher()->addListener(LineEvents::GATE_CLOSE, function (GateEvent $event) use (&$onGateClose) {
            $onGateClose = true;
        });
        $line->getDispatcher()->addListener(LineEvents::TERMINUS, function (TerminusEvent $event) use (&$onTerminus) {
            $onTerminus = true;
        });

        expect($line->lead($minibus))->toBe($minibus);
        expect($onStart)->toBe(true);
        expect($onGateOpen)->toBe(true);
        expect($onGateClose)->toBe(true);
        expect($onTerminus)->toBe(true);
    }

    function it_can_register_station_validator_listener_and_validate_entering_and_leaving_passengers()
    {
        $station1 = new BasicStation;
        $station2 = new ResolvableEnteringStation;
        $station3 = new ResolvableLeavingStation;
        $station4 = new ResolvableEnteringAndLeavingStation;
        $minibus  = new Minibus;
        $line     = new Line;

        $line->getDispatcher()->addSubscriber(new ExpectationStationSubscriber);

        $line
            ->addStation($station1)
            ->addStation($station2)
            ->addStation($station3)
            ->addStation($station4)
        ;

        expect($line->lead($minibus))->toBe($minibus);

        // test with a fail
        $minibus = new Minibus;
        $line    = new Line;
        $line->getDispatcher()->addSubscriber(new ExpectationStationSubscriber);
        $line->addStation($station2);

        try {
            $line->lead($minibus);
        } catch (MissingOptionsException $e) {
            expect($e->getMessage())->toBe('The required option "basic" is missing.');
        }
    }
}
