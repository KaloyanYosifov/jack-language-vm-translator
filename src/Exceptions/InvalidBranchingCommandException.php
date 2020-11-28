<?php

namespace JackVMTranslator\Exceptions;

class InvalidBranchingCommandException extends \Exception
{
    public function __construct(string $command)
    {
        parent::__construct("The branching command: $command is not a valid one!");
    }
}
