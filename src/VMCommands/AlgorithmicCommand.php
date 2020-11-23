<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Enums\AlgorithmicAction;

class AlgorithmicCommand implements VMCommand
{
    protected AlgorithmicAction $action;

    public function __construct(AlgorithmicAction $action)
    {
        $this->action = $action;
    }

    public function getAction(): AlgorithmicAction
    {
        return $this->action;
    }

    public function getVMCode(): string
    {
        return sprintf(
            '%s',
            $this->action->getValue()
        );
    }

    public function getAssemblerCode(): string
    {
        return '';
    }
}
