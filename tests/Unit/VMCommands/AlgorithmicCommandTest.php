<?php

namespace Unit\VMCommands;

use JackVMTranslator\Enums\AlgorithmicAction;
use JackVMTranslator\VMCommands\AlgorithmicCommand;

it('can reveal its vm code', function () {
    $command = new AlgorithmicCommand(AlgorithmicAction::ADD_ACTION());
    expect($command->getVMCode())->toEqual('add');
});
