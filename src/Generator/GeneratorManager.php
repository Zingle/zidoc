<?php

namespace Zidoc\Generator;

use League\Flysystem\Filesystem;
use phootwork\collection\ArrayList;
use Zidoc\Parser\Exception\NoSupportingParserFoundException;
use Zidoc\Parser\ParserManager;
use Zidoc\Template\FilePreprocessorInterface;
use Zidoc\Template\RendererInterface;

/**
 * Class GeneratorManager
 */
class GeneratorManager
{
    const FILE_TYPE = 'file';
    const DIR_TYPE  = 'dir';

    /**
     * @var Filesystem
     */
    private $sourcesFs;

    /**
     * @var Filesystem
     */
    private $outputFs;

    /**
     * @var ParserManager
     */
    private $parserManager;

    /**
     * @var FilePreprocessorInterface
     */
    private $preprocessor;

    /**
     * @var RendererInterface
     */
    private $renderer;


    /**
     * GeneratorManager constructor.
     *
     * @param Filesystem                $sourcesFs
     * @param Filesystem                $outputFs
     * @param ParserManager             $parserManager
     * @param FilePreprocessorInterface $preprocessor
     * @param RendererInterface         $renderer
     */
    public function __construct(
        Filesystem $sourcesFs,
        Filesystem $outputFs,
        ParserManager $parserManager,
        FilePreprocessorInterface $preprocessor,
        RendererInterface $renderer
    ) {
        $this->sourcesFs     = $sourcesFs;
        $this->outputFs      = $outputFs;
        $this->parserManager = $parserManager;
        $this->preprocessor  = $preprocessor;
        $this->renderer      = $renderer;
    }

    /**
     * @param string $dir
     */
    public function process(string $dir = '.'): void
    {
        $files = new ArrayList($this->sourcesFs->listContents($dir,true));
        $files->each(function (array $fileData) {
            if (self::DIR_TYPE === $fileData['type']) {
                return;
            }

            $this->processFile($fileData['path']);
        });
    }

    /**
     * @param string $filePath
     */
    private function processFile(string $filePath): void
    {
        try {
            $data = $this->preprocessor->extract($filePath);

            $dir = $data->getPathInfo()->getDirname();
            $outputFileName = sprintf(
                '%s.html',
                $data->getPathInfo()->getFilename()
            );

            if ($dir && '.' !== $dir) {
                $outputFileName = $dir.'/'.$outputFileName;
            }

            $frontMatter = $data->getFrontMatter();
            $content = $this->parserManager->parse($data);
            $context = [
                'content' => $content,
                '_front' => $frontMatter,
            ];
            $fileContents = $this->renderer->render(
                $frontMatter['template'] ?? 'page.twig',
                $context
            );

            $this->outputFs->put($outputFileName, $fileContents);
        } catch (NoSupportingParserFoundException $e) {
            var_dump('No supporting parser found');
        }
    }
}
