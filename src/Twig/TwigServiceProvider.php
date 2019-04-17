<?php

namespace Zidoc\Twig;

use Twig\Environment;
use Zidoc\Container;
use Zidoc\ServiceProviderInterface;
use Zidoc\Core\Config;
use Zidoc\Template\RendererInterface;
use Zidoc\Twig\Extension\ConfigExtension;

/**
 * Class TwigServiceProvider
 */
class TwigServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container): void
    {
        $container->bind(ConfigExtension::class, function (Container $container) {
            return new ConfigExtension($container->make(Config::class));
        });
        $container->bind(Environment::class, function (Container $container) {
            /** @var Config $config */
            $config = $container->make(Config::class);
            $loader = new \Twig_Loader_Filesystem($config->getTemplatePaths());

            $twig = new Environment($loader);
            $twig->addExtension($container->make(ConfigExtension::class));

            return $twig;
        });
        $container->bind(RendererInterface::class, function (Container $container) {
            return new TemplateRenderer($container->make(Environment::class));
        });
    }
}
