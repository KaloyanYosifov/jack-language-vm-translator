<?php

namespace JackVMTranslator\Exceptions;

class InvalidArithmeticActionException extends \Exception
{
    public function __construct(string $action)
    {
        parent::__construct("The algorithmic action: $action is not a valid one!");
    }
}
