<?php

namespace Knp\Minibus\Terminus;

use JMS\Serializer\Serializer;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Knp\Minibus\Minibus;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Terminus\Configuration\JmsSerializerTerminusConfiguration;
use Knp\Minibus\Configurable\ConfigurableTerminus;
use Knp\Minibus\Exception\MissingPassengerException;

/**
 * Serialize minibus passengers with the jms serializer \o/.
 */
class JmsSerializerTerminus implements ConfigurableTerminus
{
    /**
     * @var Serializer $serializer
     */
    private $serializer;

    /**
     * @var SerializationContext $context
     */
    private $context;

    /**
     * @var JmsSerializerTerminusConfiguration $configuration
     */
    private $configuration;

    /**
     * @param Serializer           $serializer
     * @param SerializationContext $context
     */
    public function __construct(
        Serializer $serializer,
        SerializationContext $context = null
    ) {
        $this->serializer    = $serializer;
        $this->context       = $context ?: SerializationContext::create();
        $this->configuration = new JmsSerializerTerminusConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Minibus $minibus, array $config)
    {
        $this->configureContext($config);

        return $this->serializer->serialize(
            $this->extractPassenger($minibus, $config['map'], $config['to_root']),
            $config['format'],
            $this->context
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param array $config
     */
    private function configureContext(array $config)
    {
        if (null !== $config['version']) {
            $this->context->setVersion($config['version']);
        }

        if (!empty($config['groups'])) {
            $this->context->setGroups($config['groups']);
        }

        if ($config['enable_max_depth_check']) {
            $this->context->enableMaxDepthChecks();
        }
    }

    private function extractPassenger(Minibus $minibus, array $map, $toRoot = true)
    {
        if (empty($map)) {
            return $minibus->getPassengers();
        }

        $finalPassenger = [];

        foreach ($map as $passenger) {
            $value = $minibus->getPassenger($passenger, null);

            if (null === $value) {
                throw new MissingPassengerException(sprintf(
                    'The passenger "%s" does not exists in the minibus.',
                    $passenger
                ));
            }

            $finalPassengers[$passenger] = $value;
        }

        if (count($finalPassengers) === 1 and $toRoot) {
            $finalPassengers = array_values($finalPassengers);
            $finalPassengers = $finalPassengers[0];
        }

        return $finalPassengers;
    }
}
