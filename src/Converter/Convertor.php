<?php

namespace JackVMTranslator\Converter;

use JackVMTranslator\Enums\MemorySegment;

interface Convertor
{
    public function convert(MemorySegment $memorySegment, string $currentFileName, int $location): string;
}