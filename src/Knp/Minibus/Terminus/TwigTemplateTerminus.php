<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Terminus\ConfigurableTerminus;
use Symfony\Component\Config\Definition\Builder\NodeParentInterface;
use Knp\Minibus\Minibus;

/**
 * Display a twig template with the given configuration.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class TwigTemplateTerminus implements ConfigurableTerminus
{
    /**
     * @var \Twig_Environment $twig
     */
    private $twig;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Minibus $minibus, array $config)
    {
        $context = $config['key'] ?
            [$config['key'] => $minibus->getPassengers()] :
            $minibus->getPassengers()
        ;

        return $this->twig->render($config['template'], $context);
    }

    /**
     * {@inheritdoc}
     */
    public function configure(NodeParentInterface $node)
    {
        $node
            ->children()
                ->scalarNode('template')->end()
                ->scalarNode('key')
                    ->defaultValue('')
                ->end()
             ->end()
        ;
    }
}
