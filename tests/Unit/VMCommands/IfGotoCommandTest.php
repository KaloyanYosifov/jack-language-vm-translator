<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\VMCommands\GotoCommand;
use JackVMTranslator\VMCommands\IfGotoCommand;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\Retrievers\StubFileRetriever;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'arithmetic-command-datasets.php';

it('can reveal its vm code', function () {
    $command = new IfGotoCommand('TESTING_LABEL');
    expect($command->getVMCode())->toEqual('if-goto TESTING_LABEL');
});

it('can reveal its assembler code', function () {
    $command = new IfGotoCommand('TESTING_LABEL_2');
    $stubService = new StubReplacerService(new StubFileRetriever());
    expect($command->getAssemblerCode($stubService))
        ->toEqual(
            $stubService->reset()->replace('LABEL_NAME', 'TESTING_LABEL_2')->handle('branching/IfGoto.stub')
        );
});
