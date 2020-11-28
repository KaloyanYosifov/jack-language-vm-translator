<?php

namespace Tests\Unit;

use JackVMTranslator\LineParser;
use JackVMTranslator\VMCommands\GotoCommand;
use JackVMTranslator\VMCommands\LabelCommand;
use JackVMTranslator\VMCommands\IfGotoCommand;
use JackVMTranslator\VMCommands\ArithmeticCommand;
use JackVMTranslator\VMCommands\MemoryAccessCommand;
use JackVMTranslator\Exceptions\CouldNotParseLineException;
use JackVMTranslator\Exceptions\InvalidArithmeticActionException;
use JackVMTranslator\Exceptions\InvalidBranchingCommandException;
use JackVMTranslator\Exceptions\InvalidMemoryAccessActionException;

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

it(
    'throws an error if nothing is found',
    fn() => (new LineParser())->parse('test'))
    ->throws(InvalidArithmeticActionException::class);

it(
    'throws an error if nothing is found with two arguments in a line',
    fn() => (new LineParser())->parse('test 2'))
    ->throws(InvalidBranchingCommandException::class, 'The branching command: test is not a valid one!');

it(
    'throws an error if nothing is found with three arguments in a line',
    fn() => (new LineParser())->parse('test test 3'))
    ->throws(InvalidMemoryAccessActionException::class);

it(
    'throws an error if nothing is found with four arguments in a line',
    fn() => (new LineParser())->parse('test test 3 5'))
    ->throws(CouldNotParseLineException::class);
