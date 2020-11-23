<?php

namespace JackVMTranslator\Retrievers;

interface StubRetriever
{
    public function handle(string $stubName): string;
}
