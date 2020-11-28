<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\Enums\ArithmeticAction;
use JackVMTranslator\VMCommands\ArithmeticCommand;
use JackVMTranslator\Exceptions\InvalidAlgorithmicActionException;

class ArithmeticResolver implements LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand
    {
        if (count($lineInParts) !== 1) {
            return null;
        }

        if (!$algorithmicAction = ArithmeticAction::search($lineInParts[0])) {
            throw new InvalidAlgorithmicActionException($lineInParts[0]);
        }

        return new ArithmeticCommand(ArithmeticAction::{$algorithmicAction}());
    }
}