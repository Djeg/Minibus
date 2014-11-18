<?php

namespace Knp\Minibus\Terminus;

use JMS\Serializer\Serializer;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Knp\Minibus\Minibus;
use JMS\Serializer\SerializationContext;
use Knp\Minibus\Http\HttpMinibus;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Terminus\Configuration\JmsSerializerTerminusConfiguration;
use Knp\Minibus\Config\ConfigurableTerminus;

/**
 * Serialize minibus passengers \o/
 *
 * @author David Jegat <david.jegat@gmail.com>
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

        if ($minibus instanceof HttpMinibus) {
            $minibus->getResponse()->headers->set('Content-Type', sprintf(
                'application/%s', $config['format']
            ));
        }

        return $this->serializer->serialize(
            $minibus->getPassengers(),
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
}
