<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\Support\Helpers;
use JackVMTranslator\VMCommands\FunctionCommand;
use Tests\Setup\Retrievers\TestStubFileRetriever;
use JackVMTranslator\Services\StubReplacerService;

it('can reveal its vm code', function () {
    $command = new FunctionCommand('Test', 2);
    expect($command->getVMCode())->toEqual('function Test 2');
});

it('creates a label when it comes across a function', function () {
    $functionCommand = new FunctionCommand('TESTING', 0);

    ob_start();
    ?>
    (TESTING)
    <?php
    $expectedCode = Helpers::cleanOB(ob_get_clean());
    expect($functionCommand->getAssemblerCode(
        new StubReplacerService(new TestStubFileRetriever()))
    )
        ->toBe($expectedCode);
});

it('creates a label along with local variables', function () {
    $functionCommand = new FunctionCommand('TESTING', 2);

    ob_start();
    ?>
    (TESTING)
    push constant 0
    pop local 0
    push constant 0
    pop local 1
    <?php
    $expectedCode = Helpers::cleanOB(ob_get_clean());
    expect($functionCommand->getAssemblerCode(
        new StubReplacerService(new TestStubFileRetriever()))
    )
        ->toBe($expectedCode);
});

