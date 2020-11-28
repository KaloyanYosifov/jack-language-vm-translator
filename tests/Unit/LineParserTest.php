<?php

namespace Tests\Unit;

use JackVMTranslator\LineParser;
use JackVMTranslator\VMCommands\GotoCommand;
use JackVMTranslator\VMCommands\LabelCommand;
use JackVMTranslator\VMCommands\IfGotoCommand;
use JackVMTranslator\VMCommands\ArithmeticCommand;
use JackVMTranslator\VMCommands\MemoryAccessCommand;
use JackVMTranslator\Exceptions\InvalidArithmeticActionException;

dataset('line_parser_dataset', [
    [
        'add',
        ArithmeticCommand::class,
    ],
    [
        'push constant 3',
        MemoryAccessCommand::class,
    ],
    [
        'goto Test',
        GotoCommand::class,
    ],
    [
        'if-goto Test',
        IfGotoCommand::class,
    ],
    [
        'label Test',
        LabelCommand::class,
    ],
]);

it('it parses the line', function (string $line, string $class) {
    $lineParser = new LineParser();

    expect($lineParser->parse($line))->toBeInstanceOf($class);
})
    ->with('line_parser_dataset');

it('throws an error if nothing is found', fn() => (new LineParser())->parse('test'))->throws(InvalidArithmeticActionException::class);