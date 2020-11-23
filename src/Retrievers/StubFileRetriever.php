<?php

namespace JackVMTranslator\Retrievers;

use JackVMTranslator\Exceptions\FileNotFoundException;

class StubFileRetriever implements StubRetriever
{
    public function handle(string $stubName): string
    {
        $stubFilePath = STUBS_PATH . DIRECTORY_SEPARATOR . $stubName;

        if (!file_exists($stubFilePath)) {
            throw new FileNotFoundException($stubName);
        }

        return file_get_contents($stubFilePath);
    }
}
