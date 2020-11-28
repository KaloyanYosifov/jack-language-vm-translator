<?php

namespace Tests\Unit;

use JackVMTranslator\LineParser;
use JackVMTranslator\Enums\MemoryAccessAction;

it('it parses the line', function () {
    $lineParser = new LineParser();

    expect($lineParser->parse('push constant 3'))->toBeInstanceOf(MemoryAccessAction::class);
});