<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\VMCommands\VMCommand;

interface LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand;
}