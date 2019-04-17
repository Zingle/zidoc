<?php

namespace Zidoc\Parser;

use Zidoc\PathInfo;

/**
 * Class FileData
 */
class FileData
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var PathInfo
     */
    private $pathInfo;

    /**
     * @var string
     */
    private $contents;

    /**
     * @var array|null
     */
    private $frontMatter;


    /**
     * TemplateData constructor.
     *
     * @param string     $filePath
     * @param string     $template
     * @param array|null $frontMatter
     */
    public function __construct(string $filePath, string $template, ?array $frontMatter)
    {
        $this->filePath    = $filePath;
        $this->pathInfo    = new PathInfo($filePath);
        $this->contents    = $template;
        $this->frontMatter = $frontMatter;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @return PathInfo
     */
    public function getPathInfo(): PathInfo
    {
        return $this->pathInfo;
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * @return array|null
     */
    public function getFrontMatter(): array
    {
        return $this->frontMatter ?? [];
    }
}
