<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\VMCommands\ReturnCommand;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\Retrievers\StubFileRetriever;

it('can reveal its vm code', function () {
    $command = new ReturnCommand();
    expect($command->getVMCode())->toEqual('return');
});

it('handles all the cleanup logic', function () {
    $command = new ReturnCommand();
    $assemblyCode = $command->getAssemblerCode(new StubReplacerService(new StubFileRetriever()));
    expect($assemblyCode)->toEqual(
        (new StubReplacerService(new StubFileRetriever()))->handle('Return.stub')
    );
});

