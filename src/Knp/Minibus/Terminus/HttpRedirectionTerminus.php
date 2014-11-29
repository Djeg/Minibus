<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Configurable\ConfigurableTerminus;
use Knp\Minibus\Minibus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Knp\Minibus\Terminus\Configuration\HttpRedirectionConfiguration as Configuration;

/**
 * Redirect to the given path.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class HttpRedirectionTerminus implements ConfigurableTerminus
{
    /**
     * @param Minibus $minibus
     * @param array   $configuration
     *
     * @return RedirectResponse
     */
    public function terminate(Minibus $minibus, array $configuration)
    {
        return new RedirectResponse($configuration['target']);
    }

    /**
     * @return HttpRefirectionConfiguration
     */
    public function getConfiguration()
    {
        return new Configuration;
    }
}
