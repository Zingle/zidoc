<?php

namespace Zidoc\Twig;

use Twig\Environment;
use Zidoc\Template\RendererInterface;

/**
 * Class TemplateRenderer
 */
class TemplateRenderer implements RendererInterface
{
    const TEMPLATE_CONFIG = 'template';

    /**
     * @var Environment
     */
    private $twig;


    /**
     * TwigRenderer constructor.
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $template
     * @param array  $context
     *
     * @return string
     *
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function renderString(string $template, array $context = []): string
    {
        $tpl = $this->twig->createTemplate($template);

        return $tpl->render($context);
    }

    /**
     * @param string $template
     * @param array  $context
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render(string $template, array $context = []): string
    {
        return $this->twig->render($template, $context);
    }
}
