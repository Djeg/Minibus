<?php

namespace funk\Knp\Minibus;

use Funk\Spec;
use Knp\Minibus\Simple\Line;
use Symfony\Component\EventDispatcher\EventDispatcher;
use example\Knp\Minibus\Station\BasicStation;
use example\Knp\Minibus\Station\OtherBasicStation;
use Knp\Minibus\Simple\Minibus;
use Knp\Minibus\Event\Subscriber\ExpectationStationSubscriber;
use example\Knp\Minibus\Station\ResolvableLeavingStation;
use example\Knp\Minibus\Station\ResolvableEnteringStation;
use example\Knp\Minibus\Station\ResolvableEnteringAndLeavingStation;

class SimpleLineFunk implements Spec
{
    function it_handle_basic_station()
    {
        $line = new Line(new EventDispatcher);

        $line->addStation(new BasicStation);
        $line->addStation(new OtherBasicStation);

        $bus = new Minibus;

        $line->follow($bus);

        expect($bus->getPassengers())->toReturn([
            'basic'       => true,
            'other_basic' => true
        ]);
    }

    function it_handle_validable_station()
    {
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new ExpectationStationSubscriber);
        $line = new Line($dispatcher);

        $line->addStation(new BasicStation);
        $line->addStation(new OtherBasicStation);
        $line->addStation(new ResolvableLeavingStation);
        $line->addStation(new ResolvableEnteringStation);
        $line->addStation(new ResolvableEnteringAndLeavingStation);

        $bus = new Minibus;

        $line->follow($bus);

        expect($bus->getPassengers())->toReturn([
            'basic'                           => true,
            'other_basic'                     => true,
            'resolvable_leaving'              => true,
            'resolvable_entering'             => true,
            'resolvable_entering_and_leaving' => true,
        ]);
    }
}
