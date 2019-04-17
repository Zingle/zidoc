<?php

namespace Zidoc\CommonMark;

use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zidoc\BootstrapperInterface;
use Zidoc\CommonMark\Event\Events;
use Zidoc\CommonMark\Listener\HeadingListener;
use Zidoc\Container;
use Zidoc\ServiceProviderInterface;

/**
 * Class CommonMarkServiceProvider
 */
class CommonMarkServiceProvider implements ServiceProviderInterface, BootstrapperInterface
{
    /**
     * @param Container $container
     */
    public function boot(Container $container): void
    {
        $headingListener = $container->make(HeadingListener::class);
        $eventDispatcher = $container->make(EventDispatcherInterface::class);
        $eventDispatcher->addListener(Events::POST_DOC_PARSE, [
            $headingListener,
            'onPostDocParse',
        ]);
    }

    /**
     * @param Container $container
     */
    public function register(Container $container): void
    {
        $container->bind(Environment::class, function (Container $container) {
            return Environment::createCommonMarkEnvironment();
        });
        $container->bind(DocParser::class, function (Container $container) {
            return new DocParser($container->make(Environment::class));
        });
        $container->bind(HtmlRenderer::class, function (Container $container) {
            return new HtmlRenderer($container->make(Environment::class));
        });
        $container->bind(Parser::class, function (Container $container) {
            return new Parser(
                $container->make(DocParser::class),
                $container->make(HtmlRenderer::class),
                $container->make(EventDispatcherInterface::class)
            );
        });
    }
}
