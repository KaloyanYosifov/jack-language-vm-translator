<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\Enums\ArithmeticAction;
use Tests\Setup\Retrievers\TestStubFileRetriever;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\VMCommands\ArithmeticCommand;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'arithmetic-command-datasets.php';

it('can reveal its vm code', function () {
    $command = new ArithmeticCommand(ArithmeticAction::ADD_ACTION());
    expect($command->getVMCode())->toEqual('add');
});

it('can reveal its assembler code', function ($action, $fileStubToExpect) {
    $command = new ArithmeticCommand($action);
    $stubService = new StubReplacerService(new TestStubFileRetriever());
    expect($command->getAssemblerCode($stubService))
        ->toEqual($stubService->handle($fileStubToExpect));
})
    ->with('arithmetic_command_tests');
