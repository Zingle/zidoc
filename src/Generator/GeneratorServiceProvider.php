<?php

namespace Zidoc\Generator;

use Zidoc\Container;
use Zidoc\Parser\ParserManager;
use Zidoc\ServiceProviderInterface;
use Zidoc\Template\FilePreprocessorInterface;
use Zidoc\Template\RendererInterface;

/**
 * Class GeneratorServiceProvider
 */
class GeneratorServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container): void
    {
        $container->bind(GeneratorManager::class, function (Container $container) {
            return new GeneratorManager(
                $container->make('sources_fs'),
                $container->make('output_fs'),
                $container->make(ParserManager::class),
                $container->make(FilePreprocessorInterface::class),
                $container->make(RendererInterface::class)
            );
        });
    }
}
