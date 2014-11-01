<?php

namespace Knp\Minibus\Terminal;

use Knp\Minibus\Terminal\TerminalCenter;
use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Minibus;
use Knp\Minibus\Http\ResponseBuilder;

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
     * @var ResponseBuilder $builder
     */
    private $builder;

    /**
     * @param TerminalCenter  $center
     * @param ResponseBuilder $builder
     */
    public function __construct(TerminalCenter $center, ResponseBuilder $builder)
    {
        $this->center  = $center;
        $this->builder = $builder;
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
        $content = $this->center->resolve($minibus, $name, $configuration);
        $response = $this->builder->build($minibus);
        $response->setContent($content);

        return $response;
    }
}
