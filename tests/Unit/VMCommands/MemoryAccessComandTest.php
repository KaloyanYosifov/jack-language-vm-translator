<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\MemoryAccessAction;
use JackVMTranslator\VMCommands\MemoryAccessCommand;

it('can reveal its vm code', function () {
    $command = new MemoryAccessCommand(MemoryAccessAction::POP_ACTION(), MemorySegment::TEMP_SEGMENT(), 4);
    expect($command->getVMCode())->toEqual('pop temp 4');
});
