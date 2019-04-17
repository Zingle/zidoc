<?php

namespace Zidoc\Template;

use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\Yaml\Yaml;
use Zidoc\Parser\FileData;

/**
 * Class Preprocessor
 */
class Preprocessor implements FilePreprocessorInterface
{
    /**
     * @var FilesystemInterface
     */
    private $sourcesFs;


    /**
     * TwigPreprocessor constructor.
     *
     * @param FilesystemInterface $sourcesFs
     */
    public function __construct(FilesystemInterface $sourcesFs)
    {
        $this->sourcesFs = $sourcesFs;
    }

    /**
     * @param string $filePath
     *
     * @return FileData
     *
     * @throws FileNotFoundException
     */
    public function extract(string $filePath): FileData
    {
        $content = $this->sourcesFs->read($filePath);

        if (preg_match('/^(?:---[\s]*[\r\n]+)(.*?)(?:---[\s]*[\r\n]+)(.*?)$/s', $content, $matches)) {
            $content = $matches[2];
            $data = Yaml::parse($matches[1]);
        }

        return new FileData($filePath, $content, $data ?? null);
    }
}
