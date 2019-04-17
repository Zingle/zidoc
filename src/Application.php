<?php

namespace Zidoc;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Application
 */
class Application extends BaseApplication
{
    const NAME = 'Zidoc';

    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $baseDir;

    /**
     * @var string
     */
    private $localDir;


    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->baseDir  = dirname(__DIR__);
        $this->localDir = getcwd();

        parent::__construct(self::NAME);
    }

    /**
     * @param InputInterface|null  $input
     * @param OutputInterface|null $output
     *
     * @return int
     *
     * @throws \Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->boot();

        return parent::run($input, $output);
    }

    /**
     * @throws \Exception
     */
    public function boot(): void
    {
        $configs = require $this->baseDir.'/etc/config.php';
        $localConfigPath = $this->baseDir.'/.zidoc.php';
        if (file_exists($localConfigPath)) {
            $localConfig = require $localConfigPath;
            $configs     = array_merge($configs, $localConfig);
        }
        $this->container = $this->buildContainer($configs);

        foreach ($this->container->make('providers') as $provider) {
            if (!$provider instanceof BootstrapperInterface) {
                continue;
            }

            $provider->boot($this->container);
        }

        foreach ($configs['commands'] as $command) {
            $this->add($this->container->make($command));
        }
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @param array $configs
     *
     * @return Container
     */
    private function buildContainer(array $configs): Container
    {
        $container = new Container();
        $container->instance('config', $configs);
        $container->instance('zidoc', $this);
        $container->instance('providers', $configs['providers']);
        $container->bind('base_dir', function () {
            return $this->baseDir;
        });
        $container->bind('local_dir', function () {
            return $this->localDir;
        });

        foreach ($container->make('providers') as $provider) {
            if (!$provider instanceof ServiceProviderInterface) {
                continue;
            }

            $provider->register($container);
        }

        return $container;
    }
}
