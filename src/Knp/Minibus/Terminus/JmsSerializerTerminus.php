<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Terminus\ConfigurableTerminus;
use JMS\Serializer\Serializer;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Knp\Minibus\Minibus;
use JMS\Serializer\SerializationContext;

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
     * @param Serializer           $serializer
     * @param SerializationContext $context
     */
    public function __construct(
        Serializer $serializer,
        SerializationContext $context = null
    ) {
        $this->serializer = $serializer;
        $this->context    = $context ?: SerializationContext::create();
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Minibus $minibus, array $config)
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

        return $this->serializer->serialize(
            $minibus->getPassengers(),
            $config['format'],
            $this->context
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('format')
                    ->defaultValue('json')
                    ->validate()
                    ->ifNotInArray(['json', 'xml', 'yml'])
                        ->thenInvalid('Invalid serialization format "%s"')
                    ->end()
                ->end()
                ->floatNode('version')
                    ->defaultNull()
                ->end()
                ->arrayNode('groups')
                    ->defaultValue([])
                    ->prototype('scalar')->end()
                ->end()
                ->booleanNode('enable_max_depth_check')
                    ->defaultFalse()
                ->end()
            ->end()
        ;
    }
}
