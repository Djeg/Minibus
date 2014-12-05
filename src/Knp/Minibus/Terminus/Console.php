<?php

namespace Knp\Minibus\Terminus;

use Knp\Minibus\Terminus;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Defined a terminus as a console endpoint. Take a look on the symfony2
 * console component ;).
 */
interface Console extends Terminus
{
    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output);

    /**
     * @param HelperSet $helpers
     */
    public function setHelpers(HelperSet $helpers);
}
