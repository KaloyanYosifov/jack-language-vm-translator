<?php

namespace JackVMTranslator\Exceptions;

class FileNotFoundException extends \Exception
{
    public function __construct(string $filename)
    {
        parent::__construct("File: $filename couldn't be found!");
    }
}
