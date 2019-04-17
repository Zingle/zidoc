<?php

namespace Zidoc\Play;

use Psy\Configuration;
use Psy\Shell;
use Zidoc\Container;
use Zidoc\ServiceProviderInterface;

/**
 * Class PlayServiceProvider
 */
class PlayServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container): void
    {
        $container->bind('psysh.config', function () {
            return new Configuration([
                'updateCheck' => 'never',
            ]);
        });
        $container->bind('psysh.shell', function (Container $container) {
            $shell = new Shell($container->make('psysh.config'));
            $shell->setScopeVariables([
                'container' => $container,
                'zidoc' => $container->make('zidoc'),
            ]);

            return $shell;
        });
        $container->bind(PlayCommand::class, function (Container $container) {
            return new PlayCommand($container->make('psysh.shell'));
        });
    }
}
