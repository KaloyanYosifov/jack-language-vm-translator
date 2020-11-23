<?php

namespace Tests\Unit\Converter;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Converter\SegmentToAssemblerNameConvertor;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'datasets.php';

it('it converts memory segment to assembler variable', function ($segment, $fileName, $location, $expectation) {
    $convertor = new SegmentToAssemblerNameConvertor();
    $converted = $convertor->convert($segment, $fileName, $location);
    expect($converted)->toEqual($expectation);
})
    ->with('memory_segment_for_conversion');

it(
    'throws an error when temp variable is out of bounds',
    fn() => (new SegmentToAssemblerNameConvertor())->convert(MemorySegment::TEMP_SEGMENT(), '', 13)
)
    ->throws(\LogicException::class, 'Temporary variable out of scope!');
it(
    'throws an error when pointer variable is out of bounds',
    fn() => (new SegmentToAssemblerNameConvertor())->convert(MemorySegment::POINTER_SEGMENT(), '', 2)
)
    ->throws(\LogicException::class, 'Pointer out of scope, please use 1 or 0.');
