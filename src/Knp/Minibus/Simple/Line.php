<?php

namespace Knp\Minibus\Simple;

use Knp\Minibus\Line as LineInterface;
use Knp\Minibus\Event\EventFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Knp\Minibus\Station;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Collection\StationCollection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Knp\Minibus\Minibus as MinibusInterface;
use Symfony\Component\Config\Definition\Processor;
use Knp\Minibus\Config\Configurable;

/**
 * This is a simple implementation of a line. This implementation should resolve
 * the most popular workflow cases. It supports events, terminus and configuration.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class Line implements LineInterface
{
    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @var \SplObjectStorage $stations
     */
    private $stations;

    /**
     * @var Terminus|null $terminus
     */
    private $terminus;

    /**
     * @var array $configuration
     */
    private $configuration;

    /**
     * @var EventFactory $eventFactory
     */
    private $eventFactory;

    /**
     * @var Processor $configurationProcessor
     */
    private $configurationProcessor;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param EventFactory             $eventFactory
     * @param Processor                $configurationProcessor
     */
    public function __construct(
        EventDispatcherInterface $dispatcher             = null,
        EventFactory             $eventFactory           = null,
        Processor                $configurationProcessor = null
    ) {
        $this->dispatcher             = $dispatcher ?: new EventDispatcher;
        $this->stations               = new \SplObjectStorage;
        $this->eventFactory           = $eventFactory ?: new EventFactory;
        $this->configurationProcessor = $configurationProcessor ?: new Processor;
        $this->terminus               = null;
        $this->configuration          = [];
    }

    /**
     * Lead the minibus thrie all the stations. If you have defined a Terminus
     * then the terminus resolved data should be return else the minibus is return.
     * This method also dispatch events
     *
     * @see LineEvents
     *
     * @param Minibus $minibus
     *
     * @return Minibus|mixed
     */
    public function lead(MinibusInterface $minibus)
    {
        // start the lead.
        $startEvent = $this->eventFactory->createStart($minibus);
        $this->dispatcher->dispatch(LineEvents::START, $startEvent);

        $minibus = $startEvent->getMinibus();

        // launch the stations
        foreach ($this->stations as $station) {
            $configuration = $this->stations[$station];
            // pre validate entering passengers
            $gateOpenEvent = $this->eventFactory->createGate($minibus, $station);
            $this->dispatcher->dispatch(LineEvents::GATE_OPEN, $gateOpenEvent);

            // parse the configuration if needed
            if ($station instanceof Configurable) {
                $configuration = $this->configurationProcessor->processConfiguration(
                    $station->getConfiguration(),
                    [$configuration]
                );
            }

            // launch the station
            $station->handle($minibus, $configuration);

            // post validate leaving passengers
            $gateCloseEvent = $this->eventFactory->createGate($minibus, $station);
            $this->dispatcher->dispatch(LineEvents::GATE_CLOSE, $gateCloseEvent);
        }

        // process terminus configuration if needed
        if (null !== $this->terminus and $this->terminus instanceof Configurable) {
            $this->configuration = $this->configurationProcessor->processConfiguration(
                $this->terminus->getConfiguration(),
                [$this->configuration]
            );
        }

        // terminate the line
        $terminusEvent = $this->eventFactory->createTerminus(
            $minibus,
            $this->terminus,
            $this->configuration
        );
        $this->dispatcher->dispatch(LineEvents::TERMINUS, $terminusEvent);

        $terminus      = $terminusEvent->getTerminus();
        $configuration = $terminusEvent->getConfiguration();

        return null === $terminus ? $minibus : $terminus->terminate($minibus, $configuration);
    }

    /**
     * {@inheritdoc}
     */
    public function addStation(Station $station, array $configuration = [])
    {
        $this->stations->attach($station, $configuration);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTerminus(Terminus $terminus, array $configuration = [])
    {
        $this->terminus      = $terminus;
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }
}
