<?php

namespace Tests\Setup\Retrievers;

use JackVMTranslator\Retrievers\StubRetriever;
use JackVMTranslator\Exceptions\FileNotFoundException;

use function Tests\getTestFilePath;

class TestStubFileRetriever implements StubRetriever
{
    public function handle(string $stubName): string
    {
        $stubFilePath = getTestFilePath(DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $stubName);

        if (!file_exists($stubFilePath)) {
            throw new FileNotFoundException($stubName);
        }

        return file_get_contents($stubFilePath);
    }
}
