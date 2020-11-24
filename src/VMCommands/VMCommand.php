<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Converter\Convertor;
use JackVMTranslator\Replacers\StubReplacer;

interface VMCommand
{
    public function getVMCode(): string;

    public function getAssemblerCode(StubReplacer $stubReplacer): string;
}
