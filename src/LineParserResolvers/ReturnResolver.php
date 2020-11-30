<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\VMCommands\ReturnCommand;

class ReturnResolver implements LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand
    {
        if (count($lineInParts) !== 1 || $lineInParts[0] !== 'return') {
            return null;
        }

        return new ReturnCommand();
    }
}