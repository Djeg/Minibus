<?php

namespace Knp\Minibus\Terminal;

use Knp\Minibus\Terminal\TerminalCenter;
use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Minibus;
use Knp\Minibus\Http\HttpMinibus;

/**
 * A simple terminal center wrapping for an http response return.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class HttpResponseTerminalCenter implements TerminalCenter
{
    /**
     * @var TerminalCenter $center
     */
    private $center;

    /**
     * @param TerminalCenter  $center
     */
    public function __construct(TerminalCenter $center)
    {
        $this->center  = $center;
    }

    /**
     * {@inheritdoc}
     */
    public function addTerminus($name, Terminus $terminus)
    {
        $this->center->addTerminus($name, $terminus);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Minibus $minibus, $name, array $configuration = [])
    {
        if (!$minibus instanceof HttpMinibus) {
            throw new \InvalidArgumentException('The HttpResponseBuilderTerminalCenter only accept HttpMinibus !');
        }

        $content  = $this->center->resolve($minibus, $name, $configuration);
        $minibus->getResponse()->setContent($content);

        return $minibus->getResponse();
    }
}
