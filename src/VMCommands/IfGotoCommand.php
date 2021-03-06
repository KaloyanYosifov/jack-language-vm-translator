<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Replacers\StubReplacer;

class IfGotoCommand implements VMCommand
{
    protected string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getVMCode(): string
    {
        return 'if-goto ' . $this->label;
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        return $stubReplacer->replace('LABEL_NAME', $this->label)
            ->handle('branching/IfGoto.stub');
    }
}
