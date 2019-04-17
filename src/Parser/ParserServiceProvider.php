<?php

namespace Zidoc\Parser;

use Zidoc\Container;
use Zidoc\ServiceProviderInterface;

/**
 * Class ParserServiceProvider
 */
class ParserServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container): void
    {
        $container->bind(ParserManager::class, function (Container $container) {
            $config = $container->make('config');
            $manager = new ParserManager();
            $parsers = $config['parsers'];

            foreach ($parsers as $parser) {
                $manager->register($container->make($parser));
            }

            return $manager;
        });
    }
}
