<?php

namespace Zidoc\Core;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zidoc\Container;
use Zidoc\ServiceProviderInterface;

/**
 * Class CoreServiceProvider
 */
class CoreServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container): void
    {
        $container->bind(EventDispatcher::class, function (Container $container) {
            return new EventDispatcher();
        });
        $container->bind(EventDispatcherInterface::class, function (Container $container) {
            return $container->make(EventDispatcher::class);
        });
        $container->bind(Config::class, function (Container $container) {
            return new Config(
                $container->make('base_dir'),
                $container->make('local_dir'),
                $container->make('config')
            );
        });
    }
}
