<?php

namespace JackVMTranslator\Exceptions;

class InvalidMemoryAccessActionException extends \Exception
{
    public function __construct(string $action)
    {
        parent::__construct("The action: $action is not a valid one!");
    }
}
