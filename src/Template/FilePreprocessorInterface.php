<?php

namespace Zidoc\Template;

use Zidoc\Parser\FileData;

/**
 * Interface FilePreprocessorInterface
 */
interface FilePreprocessorInterface
{
    /**
     * @param string $filePath
     *
     * @return FileData
     */
    public function extract(string $filePath): FileData;
}
