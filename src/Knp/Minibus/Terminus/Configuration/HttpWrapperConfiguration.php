<?php

namespace Knp\Minibus\Terminus\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * It wrap any configuration and add the default http configuration.
 */
class HttpWrapperConfiguration implements ConfigurationInterface
{
    /**
     * @var ConfigurationInterface $configuration
     */
    private $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        if (null !== $this->configuration) {
            $treeBuilder        = $this->configuration->getConfigTreeBuilder();
            $reflectionRootNode = (new \ReflectionClass($treeBuilder))
                ->getProperty('root')
            ;
            $reflectionRootNode->setAccessible(true);

            $rootNode = $reflectionRootNode->getValue($treeBuilder);

            if (null === $rootNode) {
                $rootNode = $treeBuilder->root('http');
            }
        } else {
            $treeBuilder = new TreeBuilder;
            $rootNode = $treeBuilder->root('http');
        }

        $rootNode
            ->children()
                ->integerNode('status_code')
                    ->defaultValue(200)
                ->end()
                ->arrayNode('headers')
                    ->defaultValue([])
                    ->useAttributeAsKey('name')
                    ->prototype('variable')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
