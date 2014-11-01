<?php

namespace Knp\Minibus\Terminal;

use Knp\Minibus\Minibus;
use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Exception\TerminusAlwaysExistsException;
use Knp\Minibus\Exception\TerminusNotFoundException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Knp\Minibus\Terminus\ConfigurableTerminus;

/**
 * A terminal center contains a suit of named terminus and can resolved a given
 * minibus into some terminus data.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
interface TerminalCenter
{
    /**
     * @param mixed    $name
     * @param Terminus $terminus
     *
     * @throws TerminusAlwaysExistsException
     *
     * @return TerminalCenter
     */
    public function addTerminus($name, Terminus $terminus);

    /**
     * @param Minibus $minibus
     * @param mixed   $name
     * @param array   $configuration
     *
     * @throws TerminusNotFoundException
     *
     * @return mixed the resolved terminus::terminate result
     */
    public function resolve(Minibus $minibus, $name, array $configuration = []);
}
