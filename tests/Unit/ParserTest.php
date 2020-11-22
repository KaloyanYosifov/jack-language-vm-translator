<?php

use JackVMTranslator\Parser;
use JackVMTranslator\Exceptions\FileExtensionIsNotVM;
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
    ->throws(FileExtensionIsNotVM::class);

it(
    'throws an error if no file has been opened yet',
    fn() => (new Parser())->parseLine()->next()
)
    ->throws(\LogicException::class, 'You haven\'t opened a VM file!');
