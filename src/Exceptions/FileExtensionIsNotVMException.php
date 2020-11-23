<?php

namespace JackVMTranslator\Exceptions;

class FileExtensionIsNotVMException extends \Exception
{
    public function __construct(string $filename)
    {
        parent::__construct("File: $filename is not a VM file!");
    }
}
