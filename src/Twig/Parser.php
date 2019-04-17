<?php

namespace Zidoc\Twig;

use Zidoc\Parser\FileData;
use Zidoc\Parser\ParserInterface;

/**
 * Class Parser
 */
class Parser implements ParserInterface
{
    const EXT = 'html';

    /**
     * @var TemplateRenderer
     */
    private $renderer;


    /**
     * Parser constructor.
     *
     * @param TemplateRenderer $renderer
     */
    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param string $ext
     *
     * @return bool
     */
    public function supports(string $ext): bool
    {
        return self::EXT === $ext;
    }

    /**
     * @param FileData $fileData
     *
     * @return string
     *
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function parse(FileData $fileData): string
    {
        return $this->renderer->renderString($fileData->getContents(), $fileData->getFrontMatter());
    }
}
