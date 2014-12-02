<?php

namespace Knp\Minibus\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Minibus\Event\LineEvents;
use Knp\Minibus\Event\GateEvent;
use Knp\Minibus\Expectation\ResolveEnteringPassengers;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Knp\Minibus\Expectation\ResolveLeavingPassengers;

/**
 * This subscriber can enhanced the station with some validation inside. If
 * a station implements the ResolveEnteringPassengers or ResolveLeavingPassengers
 * then an option resolver will resolve all of this passengers.
 */
class ExpectationStationSubscriber implements EventSubscriberInterface
{
    /**
     * @var OptionsResolver $resolver
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
     * @param OptionsResolver $resolver
     */
    public function __construct(OptionsResolver $resolver = null)
    {
        $this->resolver = $resolver ?: new OptionsResolver;
    }

    /**
     * @param GateEvent $event
     */
    public function validateEnteringPassengers(GateEvent $event)
    {
        if (!$event->getStation() instanceof ResolveEnteringPassengers) {
            $this->resolver->setDefaults($event->getMinibus()->getPassengers());

            return;
        }

        $event->getStation()->setEnteringPassengers($this->resolver);

        $event->getMinibus()->setPassengers($this->resolver->resolve(
            $event->getMinibus()->getPassengers()
        ));
    }

    /**
     * @param GateEvent $event
     */
    public function validateLeavingPassengers(GateEvent $event)
    {
        if (!$event->getStation() instanceof ResolveLeavingPassengers) {
            $this->resolver->setDefaults($event->getMinibus()->getPassengers());

            return;
        }

        $event->getStation()->setLeavingPassengers($this->resolver);

        $event->getMinibus()->setPassengers($this->resolver->resolve(
            $event->getMinibus()->getPassengers()
        ));
    }

    public function clearResolver()
    {
        $this->resolver = new OptionsResolver;
    }
}
