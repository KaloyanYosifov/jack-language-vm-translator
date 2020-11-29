<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\VMCommands\CallFunctionCommand;

class CallFunctionResolver implements LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand
    {
        if (count($lineInParts) !== 3 || $lineInParts[0] !== 'call') {
            return null;
        }

        return new CallFunctionCommand($lineInParts[1], (int) $lineInParts[2]);
    }
}