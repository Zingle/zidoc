<?php

namespace Zidoc;

/**
 * Class PathInfo
 */
class PathInfo
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $dirname;

    /**
     * @var string
     */
    private $basename;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     */
    private $filename;


    /**
     * PathInfo constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        list(
            'dirname'   => $this->dirname,
            'basename'  => $this->basename,
            'extension' => $this->extension,
            'filename'  => $this->filename,
        ) = array_merge([
            'dirname' => '',
            'basename'  => '',
            'extension' => '',
            'filename'  => '',
        ], pathinfo($this->path));
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }

    /**
     * @return string
     */
    public function getBasename(): string
    {
        return $this->basename;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }
}
