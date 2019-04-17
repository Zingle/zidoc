<?php

namespace Zidoc\Template;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Zidoc\Container;
use Zidoc\Core\Config;
use Zidoc\ServiceProviderInterface;

/**
 * Class TemplateServiceProvider
 */
class TemplateServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container): void
    {
        $container->bind('sources_fs',function (Container $container) {
            /** @var Config $config */
            $config  = $container->make(Config::class);
            $adapter = new Local($config->getSourcesPath());

            return new Filesystem($adapter);
        });
        $container->bind('output_fs',function (Container $container) {
            /** @var Config $config */
            $config  = $container->make(Config::class);
            $adapter = new Local($config->getOutputPath());

            return new Filesystem($adapter);
        });
        $container->bind(FilePreprocessorInterface::class, function (Container $container) {
            return new Preprocessor($container->make('sources_fs'));
        });
    }
}
