<?php

namespace Zidoc\CommonMark\Event;

use League\CommonMark\Block\Element\Document;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PostDocParseEvent
 */
class PostDocParseEvent extends Event
{
    /**
     * @var Document
     */
    private $document;


    /**
     * PostDocParseEvent constructor.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }
}
