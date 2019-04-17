<?php

namespace Zidoc\Play;

use Psy\Shell;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PlayCommand
 */
class PlayCommand extends Command
{
    const NAME = 'play';

    /**
     * @var Shell
     */
    private $shell;


    /**
     * PlayCommand constructor.
     *
     * @param Shell $shell
     */
    public function __construct(Shell $shell)
    {
        parent::__construct(self::NAME);

        $this->shell = $shell;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->shell->run();
    }
}
