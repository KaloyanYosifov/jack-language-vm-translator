<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Replacers\StubReplacer;

class LabelCommand implements VMCommand
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
        return 'label ' . $this->label;
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        return "($this->label)";
    }
}
