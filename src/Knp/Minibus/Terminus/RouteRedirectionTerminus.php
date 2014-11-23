<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Config\ConfigurableTerminus;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Knp\Minibus\Terminus\Configuration\RouteRedirectionConfiguration;
use Knp\Minibus\Minibus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Knp\Minibus\Exception\MissingPassengerException;

/**
 * Redirect to a given route.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class RouteRedirectionTerminus implements ConfigurableTerminus
{
    /**
     * @var UrlGeneratorInterface $generator
     */
    private $generator;

    /**
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param Minibus $minibus
     * @param array   $configuration
     *
     * @return RedirectResponse
     */
    public function terminate(Minibus $minibus, array $configuration)
    {
        $route         = $configuration['route'];
        $parameters    = $configuration['parameters'];
        $referenceType = $this->getReferenceType($configuration['type']);

        foreach ($parameters as $name => &$value) {
            $value = $minibus->getPassenger($value, null);

            if (null === $value) {
                throw new MissingPassengerException(sprintf(
                    'The route "%s" need the passenger "%s" but this passenger does not exists.',
                    $route,
                    $name
                ));
            }
        }

        return new RedirectResponse($this->generator->generate(
            $route,
            $parameters,
            $referenceType
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new RouteRedirectionConfiguration;
    }

    /**
     * @param string $type
     *
     * @return mixed one of the UrlGeneratorInterface constants
     */
    private function getReferenceType($type)
    {
        switch ($type) {
            case 'absolute':
                return UrlGeneratorInterface::ABSOLUTE_PATH;
            case 'url':
                return UrlGeneratorInterface::ABSOLUTE_URL;
            case 'relative':
                return UrlGeneratorInterface::RELATIVE_PATH;
            case 'network':
                return UrlGeneratorInterface::NETWORK_PATH;
            default:
                return UrlGeneratorInterface::ABSOLUTE_PATH;
        }
    }
}
