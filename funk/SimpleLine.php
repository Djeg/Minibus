<?php

namespace funk;

use Funk\Spec;
use Knp\Minibus\Simple\Minibus as SimpleMinibus;
use Knp\Minibus\Minibus;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Knp\Minibus\Simple\Line;
use Knp\Minibus\Station;
use Knp\Minibus\Expectation\OpeningGateExpectation;
use Knp\Minibus\Expectation\ClosingGateExpectation;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Knp\Minibus\Event\Subscriber\ExpectationStationSubscriber;

class SimpleLine implements Spec
{
    function it_handle_a_bus_line_with_station_and_minibus()
    {
        $minibus = new SimpleMinibus;
        $busLine = new Line(new EventDispatcher);

        $sampleStation = new SampleStation;
        $fooStation    = new FooStation;

        $busLine->addStation($sampleStation);
        $busLine->addStation($fooStation);

        $busLine->follow($minibus);

        expect($minibus->getPassengers())->toReturn([
            'sample' => true,
            'foo'    => true,
        ]);
    }

    function it_can_validate_validable_station()
    {
        $minibus = new SimpleMinibus;
        $dispatcher = new EventDispatcher;
        $dispatcher->addSubscriber(new ExpectationStationSubscriber);

        $busLine = new Line(new EventDispatcher);

        $sampleStation = new SampleStation;
        $fooStation    = new FooStation;

        $busLine->addStation($sampleStation);
        $busLine->addStation($fooStation);

        $busLine->follow($minibus);

        expect($minibus->getPassengers())->toReturn([
            'sample' => true,
            'foo'    => true,
        ]);
    }
}


class SampleStation implements Station, ClosingGateExpectation
{
    public function handle(Minibus $minibus)
    {
        $minibus->addPassenger('sample', true);
    }

    public function setLeavingPassengers(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['sample']);
        $resolver->setAllowedTypes(['sample' => 'bool']);
    }
}

class FooStation implements Station, OpeningGateExpectation
{
    public function handle(Minibus $minibus)
    {
        $minibus->addPassenger('foo', true);
    }

    public function setEnteringPassengers(OptionsResolverInterface $resolver)
    {
        $minibus->setRequired(['sample']);
    }
}
