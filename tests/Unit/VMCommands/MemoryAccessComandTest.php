<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\MemoryAccessAction;
use Tests\Setup\Retrievers\TestStubFileRetriever;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\VMCommands\MemoryAccessCommand;

it('can reveal its vm code', function () {
    $command = new MemoryAccessCommand(MemoryAccessAction::POP_ACTION(), MemorySegment::TEMP_SEGMENT(), 4);
    expect($command->getVMCode())->toEqual('pop temp 4');
});

it('can reveal its assembler code', function () {
    $command = new MemoryAccessCommand(MemoryAccessAction::POP_ACTION(), MemorySegment::TEMP_SEGMENT(), 4);
    expect(
        $command->getAssemblerCode(
            new StubReplacerService(new TestStubFileRetriever())
        )
    )
        ->toEqual(
            <<<EOF
            @LCL
            A=M+4
            EOF
        );
});
