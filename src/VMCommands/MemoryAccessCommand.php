<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\MemoryAccessAction;

class MemoryAccessCommand
{
    protected MemoryAccessAction $memoryAccessAction;
    protected MemorySegment $memorySegment;
    protected int $location;

    /**
     * MemoryAccessCommand constructor.
     * @param MemoryAccessAction $memoryAccessAction
     * @param MemorySegment $memorySegment
     * @param int $location
     */
    public function __construct(MemoryAccessAction $memoryAccessAction, MemorySegment $memorySegment, int $location)
    {
        $this->memoryAccessAction = $memoryAccessAction;
        $this->memorySegment = $memorySegment;
        $this->location = $location;
    }

    public function getAccessAction(): MemoryAccessAction
    {
        return $this->memoryAccessAction;
    }

    public function getSegment(): MemorySegment
    {
        return $this->memorySegment;
    }

    public function getLocation(): int
    {
        return $this->location;
    }
}
