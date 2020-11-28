<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\VMCommands\GotoCommand;
use JackVMTranslator\VMCommands\LabelCommand;
use JackVMTranslator\VMCommands\IfGotoCommand;
use JackVMTranslator\Exceptions\InvalidBranchingCommandException;

class BranchingResolver implements LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand
    {
        if (count($lineInParts) !== 2) {
            return null;
        }

        [$command, $label] = $lineInParts;

        $commands = [
            'goto' => GotoCommand::class,
            'label' => LabelCommand::class,
            'if-goto' => IfGotoCommand::class,
        ];

        if (!array_key_exists($command, $commands)) {
            throw new InvalidBranchingCommandException($command);
        }

        return new $commands[strtolower($command)]($label);
    }
}