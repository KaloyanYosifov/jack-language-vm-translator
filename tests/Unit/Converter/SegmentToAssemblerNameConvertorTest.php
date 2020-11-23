<?php

namespace Tests\Unit\Converter;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Converter\SegmentToAssemblerNameConvertor;

it('it converts memory segment to assembler variable', function ($segment, $fileName, $location, $expectation) {
    $convertor = new SegmentToAssemblerNameConvertor();
    $converted = $convertor->convert($segment, $fileName, $location);
    expect($converted)->toEqual($expectation);
})
    ->with([
        [
            MemorySegment::LOCAL_SEGMENT(),
            '',
            0,
            'LCL',
        ],
        [
            MemorySegment::ARGUMENT_SEGMENT(),
            '',
            0,
            'ARG',
        ],
        [
            MemorySegment::THIS_SEGMENT(),
            '',
            0,
            'THIS',
        ],
        [
            MemorySegment::THAT_SEGMENT(),
            '',
            0,
            'THAT',
        ],
        [
            MemorySegment::CONSTANT_SEGMENT(),
            '',
            55,
            '55',
        ],
        [
            MemorySegment::TEMP_SEGMENT(),
            '',
            5,
            'R10',
        ],
        [
            MemorySegment::STATIC_SEGMENT(),
            'Gangster.txt',
            5,
            'Gangster.5',
        ],
        [
            MemorySegment::POINTER_SEGMENT(),
            '',
            0,
            'THIS',
        ],
        [
            MemorySegment::POINTER_SEGMENT(),
            '',
            1,
            'THAT',
        ],
    ]);