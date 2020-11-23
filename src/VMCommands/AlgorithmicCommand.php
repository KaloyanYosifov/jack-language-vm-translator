<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Enums\AlgorithmicAction;

class AlgorithmicCommand
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
}
