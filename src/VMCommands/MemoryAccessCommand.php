<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Replacers\StubReplacer;
use JackVMTranslator\Enums\MemoryAccessAction;

class MemoryAccessCommand implements VMCommand
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

    public function getVMCode(): string
    {
        return sprintf(
            '%s %s %s',
            $this->memoryAccessAction->getValue(),
            $this->memorySegment->getValue(),
            $this->location
        );
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        return $stubReplacer
            ->replace('SEGMENT_LOCATION', )
            ->handle(
            sprintf('%sStack.stub', ucfirst($this->memoryAccessAction->getValue()))
        );
    }
}
