<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Configurable\ConfigurableTerminus;
use Knp\Minibus\Terminus;
use Knp\Minibus\Minibus;
use Symfony\Component\HttpFoundation\Response;
use Knp\Minibus\Configurable;
use Knp\Minibus\Terminus\Configuration\HttpWrapperConfiguration;

/**
 * Wrapp any kind of terminus into an http response.
 */
class HttpWrapperTerminus implements ConfigurableTerminus
{
    /**
     * @var Terminus $terminus
     */
    private $terminus;

    /**
     * @param Terminus $terminus
     */
    public function __construct(Terminus $terminus)
    {
        $this->terminus = $terminus;
    }

    /**
     * {@inheritdoc}
     */
    public function terminate(Minibus $minibus, array $configuration)
    {
        return new Response(
            $this->terminus->terminate($minibus, $configuration),
            $configuration['status_code'],
            $configuration['headers']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        if ($this->terminus instanceof Configurable) {
            return new HttpWrapperConfiguration($this->terminus->getConfiguration());
        }

        return new HttpWrapperConfiguration;
    }
}
