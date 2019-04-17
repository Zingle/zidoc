<?php

namespace Zidoc\Parser;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * @param FileData $fileData
     *
     * @return string
     */
    public function parse(FileData $fileData): string;

    /**
     * @param string $ext
     *
     * @return bool
     */
    public function supports(string $ext): bool;
}
