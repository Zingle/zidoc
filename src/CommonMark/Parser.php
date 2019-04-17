<?php

namespace Zidoc\CommonMark;

use League\CommonMark\DocParser;
use League\CommonMark\HtmlRenderer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zidoc\CommonMark\Event\Events;
use Zidoc\CommonMark\Event\PostDocParseEvent;
use Zidoc\Parser\FileData;
use Zidoc\Parser\ParserInterface;

/**
 * Class Parser
 */
class Parser implements ParserInterface
{
    const EXT = 'md';

    /**
     * @var DocParser
     */
    private $docParser;

    /**
     * @var HtmlRenderer
     */
    private $htmlRenderer;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;


    /**
     * MarkdownParser constructor.
     *
     * @param DocParser                $docParser
     * @param HtmlRenderer             $htmlRenderer
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(DocParser $docParser, HtmlRenderer $htmlRenderer, EventDispatcherInterface $eventDispatcher)
    {
        $this->docParser       = $docParser;
        $this->htmlRenderer    = $htmlRenderer;
        $this->eventDispatcher = $eventDispatcher;
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
     */
    public function parse(FileData $fileData): string
    {
        $document = $this->docParser->parse($fileData->getContents());
        $event = new PostDocParseEvent($document);
        $this->eventDispatcher->dispatch(Events::POST_DOC_PARSE, $event);

        return $this->htmlRenderer->renderBlock($document);
    }
}
