<?php

namespace Tests\Unit;

use JackVMTranslator\LineParser;
use JackVMTranslator\VMCommands\MemoryAccessCommand;

it('it parses the line', function () {
    $lineParser = new LineParser();

    expect($lineParser->parse('push constant 3'))->toBeInstanceOf(MemoryAccessCommand::class);
});