<?php

namespace Tests\Unit;

use JackVMTranslator\Parser;
use JackVMTranslator\LineParser;
use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\ArithmeticAction;
use JackVMTranslator\Enums\MemoryAccessAction;
use JackVMTranslator\Exceptions\FileNotFoundException;
use JackVMTranslator\Exceptions\FileExtensionIsNotVMException;

use function Tests\getTestFilePath;

it(
    'throws an error if file is not found',
    fn() => (new Parser(new LineParser()))->open('not-found.vm')
)
    ->throws(FileNotFoundException::class);

it(
    'throws an error if the file is not with the .vm extension',
    fn() => (new Parser(new LineParser()))->open('test.txt')
)
    ->throws(FileExtensionIsNotVMException::class);

it(
    'throws an error if no file has been opened yet',
    fn() => (new Parser(new LineParser()))->parseLine()->next()
)
    ->throws(\LogicException::class, 'You haven\'t opened a VM file!');

it('parses the lines in the vm code', function () {
    $parser = new Parser(new LineParser());
    $parser->open(getTestFilePath('SimpleAdd.vm'));
    $LINES_OF_CODE_IN_FILE = 3;
    $parseLineFunction = $parser->parseLine();

    for ($i = 0; $i < $LINES_OF_CODE_IN_FILE; $i++) {
        $command = $parseLineFunction->current();

        if ($i === 0) {
            expect($command->getAccessAction()->getValue())->toEqual(MemoryAccessAction::PUSH_ACTION()->getValue());
            expect($command->getSegment()->getValue())->toEqual(MemorySegment::CONSTANT_SEGMENT()->getValue());
            expect($command->getLocation())->toEqual(7);
        } elseif ($i === 1) {
            expect($command->getAccessAction()->getValue())->toEqual(MemoryAccessAction::PUSH_ACTION()->getValue());
            expect($command->getSegment()->getValue())->toEqual(MemorySegment::CONSTANT_SEGMENT()->getValue());
            expect($command->getLocation())->toEqual(8);
        } elseif ($i === 2) {
            expect($command->getAction()->getValue())->toEqual(ArithmeticAction::ADD_ACTION()->getValue());
        }

        $parseLineFunction->next();
    }

    $parser->close();
});

it('skips commented lines and removes comment from code', function () {
    $parser = new Parser(new LineParser());
    $parser->open(getTestFilePath('SimpleAddWithComments.vm'));
    $parseLine = $parser->parseLine();
    $command = $parseLine->current();

    expect($command->getAccessAction()->getValue())->toEqual(MemoryAccessAction::PUSH_ACTION()->getValue());
    expect($command->getSegment()->getValue())->toEqual(MemorySegment::CONSTANT_SEGMENT()->getValue());
    expect($command->getLocation())->toEqual(7);

    $parseLine->next();

    $command = $parseLine->current();

    expect($command->getAccessAction()->getValue())->toEqual(MemoryAccessAction::PUSH_ACTION()->getValue());
    expect($command->getSegment()->getValue())->toEqual(MemorySegment::CONSTANT_SEGMENT()->getValue());
    expect($command->getLocation())->toEqual(8);

    $parser->close();
});
