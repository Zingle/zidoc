<?php

namespace Zidoc\Core;

use phootwork\collection\Map;

/**
 * Class Config
 */
class Config
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @var string
     */
    private $localPath;

    /**
     * @var Map
     */
    private $config;


    /**
     * Config constructor.
     *
     * @param string $basePath
     * @param string $localPath
     * @param array  $config
     */
    public function __construct(string $basePath, string $localPath, array $config)
    {
        $this->basePath  = $basePath;
        $this->localPath = $localPath;
        $this->config    = new Map($config);
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function getLocalPath(): string
    {
        return $this->localPath;
    }

    /**
     * @return string
     */
    public function getTemplatesDir(): string
    {
        return $this->config['templatesDir'];
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->config['theme'];
    }

    /**
     * @return string
     */
    public function getLocalTemplatesPath(): string
    {
        return sprintf('%s/%s', $this->localPath, $this->getTemplatesDir());
    }

    /**
     * @return string
     */
    public function getSourcesPath(): string
    {
        return sprintf('%s/%s', $this->getLocalPath(), $this->config['source']);
    }

    /**
     * @return string
     */
    public function getOutputPath(): string
    {
        return sprintf('%s/%s', $this->getLocalPath(), $this->config['output']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config->get('name');
    }

    /**
     * @return array
     */
    public function getTemplatePaths(): array
    {
        $paths = [
            sprintf('%s/themes/%s', $this->getBasePath(), $this->getTheme()),
        ];
        if (is_dir($this->getLocalTemplatesPath())) {
            array_unshift($paths, $this->getLocalTemplatesPath());
        }

        return $paths;
    }
}
