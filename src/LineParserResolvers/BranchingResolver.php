<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\VMCommands\GotoCommand;
use JackVMTranslator\VMCommands\LabelCommand;
use JackVMTranslator\VMCommands\IfGotoCommand;

class BranchingResolver implements LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand
    {
        if (count($lineInParts) !== 2) {
            return null;
        }

        $commands = [
            'goto' => GotoCommand::class,
            'label' => LabelCommand::class,
            'if-goto' => IfGotoCommand::class,
        ];

        return new $commands[strtolower($lineInParts[1])];
    }
}