<?php

namespace Zidoc\Generator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zidoc\Core\Config;

/**
 * Class GenerateCommand
 */
class GenerateCommand extends Command
{
    const NAME = 'generate';

    /**
     * @var GeneratorManager
     */
    private $generatorManager;

    /**
     * @var \Zidoc\Core\Config
     */
    private $config;


    /**
     * GenerateCommand constructor.
     *
     * @param GeneratorManager $generatorManager
     * @param \Zidoc\Core\Config           $config
     */
    public function __construct(GeneratorManager $generatorManager, Config $config)
    {
        parent::__construct(self::NAME);

        $this->generatorManager = $generatorManager;
        $this->config           = $config;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf(
            'Starting to process contents of %s',
            $this->config->getSourcesPath()
        ));
        $this->generatorManager->process();
    }
}
