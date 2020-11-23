<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\MemoryAccessAction;
use Tests\Setup\Retrievers\TestStubFileRetriever;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\VMCommands\MemoryAccessCommand;
use JackVMTranslator\Converter\SegmentToAssemblerNameConvertor;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'datasets.php';

it('can reveal its vm code', function () {
    $command = new MemoryAccessCommand(MemoryAccessAction::POP_ACTION(), MemorySegment::TEMP_SEGMENT(), 4, '');
    expect($command->getVMCode())->toEqual('pop temp 4');
});

it('can reveal its assembler code', function ($action, $dataSets) {
    foreach ($dataSets as [$segment, $location, $equal]) {
        $command = new MemoryAccessCommand($action, $segment, $location, 'SomeFile.tst');
        expect(
            $command->getAssemblerCode(
                new StubReplacerService(new TestStubFileRetriever()),
                new SegmentToAssemblerNameConvertor()
            )
        )
            ->toEqual($equal);
    }
})
    ->with('memory_access_command_tests');

it(
    'throws an error if we use a pop action for constant',
    fn() => new MemoryAccessCommand(MemoryAccessAction::POP_ACTION(), MemorySegment::CONSTANT_SEGMENT(), 4, '')
)
    ->throws(\LogicException::class, 'Cannot put value to constant segment!');
