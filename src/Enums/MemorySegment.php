<?php

namespace JackVMTranslator\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static MemorySegment LOCAL_SEGMENT()
 * @method static MemorySegment ARGUMENT_SEGMENT()
 * @method static MemorySegment THIS_SEGMENT()
 * @method static MemorySegment THAT_SEGMENT()
 * @method static MemorySegment CONSTANT_SEGMENT()
 * @method static MemorySegment STATIC_SEGMENT()
 * @method static MemorySegment POINTER_SEGMENT()
 * @method static MemorySegment TEMP_SEGMENT()
 */
class MemorySegment extends Enum
{
    private const LOCAL_SEGMENT = 'local';
    private const ARGUMENT_SEGMENT = 'argument';
    private const THIS_SEGMENT = 'this';
    private const THAT_SEGMENT = 'that';
    private const CONSTANT_SEGMENT = 'constant';
    private const STATIC_SEGMENT = 'static';
    private const POINTER_SEGMENT = 'pointer';
    private const TEMP_SEGMENT = 'temp';
}
