<?php

namespace spec\Knp\Minibus\Collection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Knp\Minibus\Station;

class StationCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Minibus\Collection\StationCollection');
    }

    function it_is_an_iterator()
    {
        $this->shouldHaveType('Iterator');
    }

    function it_collect_station_and_configuration(Station $station1, Station $station2, Station $station3)
    {
        $this->add($station1, ['some configuration']);
        $this->add($station2, ['some other configuration']);

        $this->contains($station1)->shouldReturn(true);
        $this->contains($station2)->shouldReturn(true);
        $this->contains($station3)->shouldReturn(false);
    }

    function it_iterate_thrue_station_and_configuration(Station $station1, Station $station2)
    {
        $this->add($station1, ['station1 configuration']);
        $this->add($station2, ['station2 configuration']);

        $this->shouldIterateThrueStationAndConfiguration($station1, $station2, ['station1 configuration'], ['station2 configuration']);
    }

    function getMatchers()
    {
        return [
            'iterateThrueStationAndConfiguration' => function ($iterator, $station1, $station2, $conf1, $conf2) {
                $i = 0;
                foreach ($iterator as $station => $configuration) {
                    if ($i === 0) {
                        if ($station1 !== $station) {
                            return false;
                        }

                        if ($configuration !== $conf1) {
                            return false;
                        }
                    } else {
                        if ($station2 !== $station) {
                            return false;
                        }

                        if ($configuration !== $conf2) {
                            return false;
                        }
                    }

                    $i++;
                }

                return true;
            }
        ];
    }
}
