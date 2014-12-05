<?php

namespace Knp\Minibus\Terminus\Console;

use Knp\Minibus\Terminus\Console;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * A standard implementation of a console terminus.
 */
abstract class ConsoleTerminus implements Console
{
    /**
     * @var OutputInterface $output
     */
    protected $output;

    /**
     * @var HelperSet $helpers
     */
    protected $helpers;

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param HelperSet $helperSet
     */
    public function setHelpers(HelperSet $helperSet)
    {
        $this->helpers = $helperSet;
    }
}
