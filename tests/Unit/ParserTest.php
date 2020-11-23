<?php

use JackVMTranslator\Parser;
use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\AlgorithmicAction;
use JackVMTranslator\Enums\MemoryAccessAction;
use JackVMTranslator\VMCommands\MemoryAccessCommand;
use JackVMTranslator\Exceptions\FileExtensionIsNotVMException;
use JackVMTranslator\Exceptions\FileNotFoundException;

use function Tests\getTestFilePath;

it(
    'throws an error if file is not found',
    fn() => (new Parser())->open('not-found.vm')
)
    ->throws(FileNotFoundException::class);

it(
    'throws an error if the file is not with the .vm extension',
    fn() => (new Parser())->open('test.txt')
)
    ->throws(FileExtensionIsNotVMException::class);

it(
    'throws an error if no file has been opened yet',
    fn() => (new Parser())->parseLine()->next()
)
    ->throws(\LogicException::class, 'You haven\'t opened a VM file!');

it('parses the lines in the vm code', function () {
    $parser = new Parser();
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
            expect($command->getAction()->getValue())->toEqual(AlgorithmicAction::ADD_ACTION()->getValue());
        }

        $parseLineFunction->next();
    }

    $parser->close();
});
