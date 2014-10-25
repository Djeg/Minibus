<?php

namespace Knp\Minibus\Simple;

use Knp\Minibus\Line as LineInterface;
use Knp\Minibus\Event\EventFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Knp\Minibus\Station;
use Knp\Minibus\Minibus as MinibusInterface;
use Knp\Minibus\Event\LineEvents;

class Line implements LineInterface
{
    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @var EventFactory $eventFactory
     */
    private $eventFactory;

    /**
     * @var Station[] $stations
     */
    private $stations;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param EventFactory             $eventFactory
     */
    public function __construct(EventDispatcherInterface $dispatcher, EventFactory $eventFactory = null)
    {
        $this->dispatcher   = $dispatcher;
        $this->eventFactory = $eventFactory ?: new EventFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function addStation(Station $station)
    {
        $this->stations[] = $station;

        return $this;
    }

    public function follow(MinibusInterface $minibus)
    {
        $startEvent = $this->eventFactory->createStart();
        $startEvent->setMinibus($minibus);

        $this->dispatcher->dispatch(LineEvents::START, $startEvent);

        $minibus = $startEvent->getMinibus();

        foreach ($this->stations as $station) {
            $openGateEvent = $this->eventFactory->createGate($minibus, $station);
            $this->dispatcher->dispatch(LineEvents::GATE_OPEN, $openGateEvent);

            $station->handle($minibus);

            $closeGateEvent = $this->eventFactory->createGate($minibus, $station);
            $this->dispatcher->dispatch(LineEvents::GATE_CLOSE, $closeGateEvent);
        }

        $terminusEvent = $this->eventFactory->createTerminus($minibus);
        $this->dispatcher->dispatch(LineEvents::TERMINUS, $terminusEvent);

        return $terminusEvent->getFinalData();
    }
}
