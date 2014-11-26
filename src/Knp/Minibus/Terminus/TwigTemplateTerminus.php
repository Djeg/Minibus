<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Minibus;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Knp\Minibus\Config\ConfigurableTerminus;
use Knp\Minibus\Terminus\Configuration\TwigTemplateTerminusConfiguration;

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
     * @var TwigTemplateTerminusConfiguration $configuration
     */
    private $configuration;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig          = $twig;
        $this->configuration = new TwigTemplateTerminusConfiguration;
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
        $context = array_merge($config['defaults'], $context);

        return $this->twig->render($config['template'], $context);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
