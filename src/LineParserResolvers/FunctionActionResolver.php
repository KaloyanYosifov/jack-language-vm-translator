<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\VMCommands\FunctionCommand;

class FunctionActionResolver implements LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand
    {
        if (count($lineInParts) !== 3 || $lineInParts[0] !== 'function') {
            return null;
        }

        return new FunctionCommand($lineInParts[1], (int) $lineInParts[2]);
    }
}