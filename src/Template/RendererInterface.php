<?php

namespace Zidoc\Template;

/**
 * Interface RendererInterface
 */
interface RendererInterface
{
    /**
     * @param string $template
     * @param array  $context
     *
     * @return string
     */
    public function render(string $template, array $context = []): string;
}
