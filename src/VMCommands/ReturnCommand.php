<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Replacers\StubReplacer;

class ReturnCommand implements VMCommand
{
    public function getVMCode(): string
    {
        return 'return';
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        return $stubReplacer->handle('Return.stub');
    }
}