<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Replacers\StubReplacer;

class InitializationCommand implements VMCommand
{
    public function getVMCode(): string
    {
        return '';
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        return $stubReplacer
            ->handle('Initialization.stub');
    }
}
