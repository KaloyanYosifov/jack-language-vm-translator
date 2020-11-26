<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\VMCommands\LabelCommand;
use Tests\Setup\Retrievers\TestStubFileRetriever;
use JackVMTranslator\Services\StubReplacerService;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'arithmetic-command-datasets.php';

it('can reveal its vm code', function () {
    $command = new LabelCommand('TESTING_LABEL');
    expect($command->getVMCode())->toEqual('label TESTING_LABEL');
});

it('can reveal its assembler code', function () {
    $command = new LabelCommand('TESTING_LABEL');
    $stubService = new StubReplacerService(new TestStubFileRetriever());
    expect($command->getAssemblerCode($stubService))
        ->toEqual('(TESTING_LABEL)');
});
