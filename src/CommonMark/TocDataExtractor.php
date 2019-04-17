<?php

namespace Zidoc\CommonMark;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\DocParser;
use League\CommonMark\Node\Node;
use League\Flysystem\Filesystem;
use phootwork\collection\ArrayList;
use phootwork\collection\Map;
use phootwork\collection\Queue;

/**
 * Class TocDataExtractor
 */
class TocDataExtractor
{
    /**
     * @var DocParser
     */
    private $docParser;


    /**
     * TocDataExtractor constructor.
     *
     * @param DocParser  $docParser
     * @param Filesystem $sourcesFs
     */
    public function __construct(DocParser $docParser, Filesystem $sourcesFs)
    {
        $this->docParser = $docParser;
    }

    public function extract(string $filePath)
    {
        $document = $this->docParser->parse(file_get_contents($filePath));
        $nodes = new ArrayList($document->children());
        $headings = $nodes->filter(function (Node $node) {
            return $node instanceof Heading;
        });

        $headings->each(function (Heading $heading) {
            $heading->getLevel();
        });
    }

    private function toStructured(ArrayList $headings, int $currentLevel = 1)
    {
        $queue = new Queue($headings);
        while ($heading = $queue->poll()) {

        }
        $headings->each(function (Heading $heading) use ($headings, $currentLevel) {

        });
    }
}
