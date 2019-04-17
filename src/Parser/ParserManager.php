<?php

namespace Zidoc\Parser;

use phootwork\collection\ArrayList;
use Zidoc\Parser\Exception\NoSupportingParserFoundException;

/**
 * Class ParserManager
 */
class ParserManager
{
    /**
     * @var ArrayList
     */
    private $storage;


    /**
     * ParserManager constructor.
     */
    public function __construct()
    {
        $this->storage   = new ArrayList();
    }

    /**
     * @param ParserInterface $parser
     */
    public function register(ParserInterface $parser): void
    {
        $this->storage->add($parser);
    }

    /**
     * @param string $type
     *
     * @return ParserInterface
     *
     * @throws NoSupportingParserFoundException
     */
    public function get(string $type): ParserInterface
    {
        $qualified = $this->storage->filter(function (ParserInterface $parser) use ($type) {
            return $parser->supports($type);
        });

        if ($qualified->isEmpty()) {
            throw new NoSupportingParserFoundException();
        }

        return $qualified->get(0);
    }

    /**
     * @param FileData $fileData
     *
     * @return string
     *
     * @throws NoSupportingParserFoundException
     */
    public function parse(FileData $fileData): string
    {
        return $this->get($fileData->getPathInfo()->getExtension())->parse($fileData);
    }
}
