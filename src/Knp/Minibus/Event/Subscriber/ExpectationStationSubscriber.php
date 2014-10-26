<?php

namespace Knp\Minibus\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Event\GateEvent;
use Knp\Minibus\Expectation\ResolveEnteringPassengers;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Knp\Minibus\Expectation\ResolveLeavingPassengers;

/**
 * This subscriber can enhanced the station with some validation inside. If
 * a station implements the ResolveEnteringPassengers or ResolveLeavingPassengers
 * then an option resolver will resolve all of this stop.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class ExpectationStationSubscriber implements EventSubscriberInterface
{
    /**
     * @var OptionsResolverInterface $resolver
     */
    private $resolver;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            LineEvents::GATE_OPEN  => 'validateEnteringPassengers',
            LineEvents::GATE_CLOSE => 'validateLeavingPassengers',
            LineEvents::TERMINUS   => 'clearResolver',
        ];
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function __construct(OptionsResolverInterface $resolver = null)
    {
        $this->resolver                 = $resolver ?: new OptionsResolver;
    }

    /**
     * @param GateEvent $event
     */
    public function validateEnteringPassengers(GateEvent $event)
    {
        $minibus = $event->getMinibus();
        $station = $event->getStation();

        if (!$station instanceof ResolveEnteringPassengers) {
            $this->resolver->setDefaults($minibus->getPassengers());

            return;
        }

        $station->setEnteringPassengers($this->resolver);

        $minibus->setPassengers($this->resolver->resolve($minibus->getPassengers()));
    }

    /**
     * @param GateEvent $event
     */
    public function validateLeavingPassengers(GateEvent $event)
    {
        $minibus = $event->getMinibus();
        $station = $event->getStation();

        if (!$station instanceof ResolveLeavingPassengers) {
            $this->resolver->setDefaults($minibus->getPassengers());

            return;
        }

        $station->setLeavingPassengers($this->resolver);

        $minibus->setPassengers($this->resolver->resolve($minibus->getPassengers()));
    }

    public function clearResolver()
    {
        $this->resolver = new OptionsResolver;
    }
}
