<?php

namespace Knp\Minibus\Terminal;

use Knp\Minibus\Minibus;
use Knp\Minibus\Terminus\Terminus;
use Knp\Minibus\Exception\TerminusAlwaysExistException;
use Knp\Minibus\Exception\TerminusNotFoundException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Knp\Minibus\Terminus\ConfigurableTerminus;

/**
 * Contains all the terminus.
 *
 * @author David Jegat <david.jegat@gmail.com>
 */
class TerminalCenter
{
    /**
     * @var Minibus $minibus
     */
    private $minibus;

    /**
     * @var Terminus[] $terminals
     */
    private $terminals;

    /**
     * @var Processor $processor
     */
    private $processor;

    /**
     * @var TreeBuilder $builder
     */
    private $builder;

    /**
     * @param Minibus $minibus
     */
    public function __construct(
        Minibus $minibus,
        Processor $processor = null,
        TreeBuilder $builder = null
    ) {
        $this->minibus   = $minibus;
        $this->terminals = [];
        $this->processor = $processor ?: new Processor;
        $this->builder   = $builder ?: new TreeBuilder;
    }

    /**
     * @param mixed    $name
     * @param Terminus $terminus
     *
     * @throws TerminusAlwaysExistException
     *
     * @return TerminalCenter
     */
    public function addTerminus($name, Terminus $terminus)
    {
        if (isset($this->terminals[$name])) {
            throw new TerminusAlwaysExistException(sprintf(
                'the terminus %s is always present in the terminal center :-(',
                $name
            ));
        }

        $this->terminals[$name] = $terminus;

        return $this;
    }

    /**
     * @param mixed $name
     * @param array $configuration
     *
     * @throws TerminusNotFoundException
     *
     * @return mixed, the resolved terminus::terminate result
     */
    public function resolve($name, array $configuration = [])
    {
        if (!isset($this->terminals[$name])) {
            throw new TerminusNotFoundException(sprintf(
                'The terminus %s does not seems to be registered inside the terminal center :-(',
                $name
            ));
        }

        $terminus = $this->terminals[$name];

        if ($terminus instanceof ConfigurableTerminus) {
            $terminus->configure($this->builder->root($name));
            $configuration = $this->processor->process($this->builder->buildTree(), [$configuration]);
        }

        return $terminus->terminate($this->minibus, $configuration);
    }
}
