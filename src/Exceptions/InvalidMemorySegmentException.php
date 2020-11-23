<?php

namespace JackVMTranslator\Exceptions;

class InvalidMemorySegmentException extends \Exception
{
    public function __construct(string $segment)
    {
        parent::__construct("The segment: $segment is not a valid one!");
    }
}
