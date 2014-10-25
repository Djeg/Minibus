<?php

namespace funk;

use Funk\Spec;
use Knp\Minibus\Simple\Minibus as SimpleMinibus;
use Knp\Minibus\Minibus;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Knp\Minibus\Simple\Line;
use Knp\Minibus\Station;

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
}


class SampleStation implements Station
{
    public function handle(Minibus $minibus)
    {
        $minibus->addPassenger('sample', true);
    }
}

class FooStation implements Station
{
    public function handle(Minibus $minibus)
    {
        $minibus->addPassenger('foo', true);
    }
}
