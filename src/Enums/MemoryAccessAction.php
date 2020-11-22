<?php

namespace JackVMTranslator\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static MemoryAccessAction POP_ACTION()
 * @method static MemoryAccessAction PUSH_ACTION()
 */
class MemoryAccessAction extends Enum
{
    private const POP_ACTION = 'pop';
    private const PUSH_ACTION = 'push';
}
