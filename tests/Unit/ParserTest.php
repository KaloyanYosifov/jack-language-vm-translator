<?php

use JackVMTranslator\Parser;
use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\MemoryAccessAction;
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

    foreach ($parser->parseLine() as $command) {
        if ($command instanceof \JackVMTranslator\VMCommands\MemoryAccessCommand) {
            expect($command->getAccessAction()->getValue())->toEqual(MemoryAccessAction::PUSH_ACTION()->getValue());
            expect($command->getSegment()->getValue())->toEqual(MemorySegment::CONSTANT_SEGMENT()->getValue());
            expect($command->getLocation())->toEqual(7);
        }

        break;
    }

    $parser->close();
});
