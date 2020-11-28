<?php

namespace JackVMTranslator\Exceptions;

class CouldNotParseLineException extends \Exception
{
    public function __construct(string $line)
    {
        parent::__construct('Line couldn\'t be parsed: ' . $line);
    }
}