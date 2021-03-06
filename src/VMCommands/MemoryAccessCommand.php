<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Replacers\StubReplacer;
use JackVMTranslator\Enums\MemoryAccessAction;
use JackVMTranslator\Converter\SegmentToAssemblerNameConvertor;

class MemoryAccessCommand implements VMCommand, VMCommandWithFileKnowledge
{
    protected MemoryAccessAction $memoryAccessAction;
    protected MemorySegment $memorySegment;
    protected int $location;
    protected string $currentFileName = '';

    /**
     * MemoryAccessCommand constructor.
     * @param MemoryAccessAction $memoryAccessAction
     * @param MemorySegment $memorySegment
     * @param int $location
     */
    public function __construct(
        MemoryAccessAction $memoryAccessAction,
        MemorySegment $memorySegment,
        int $location
    ) {
        $this->memoryAccessAction = $memoryAccessAction;
        $this->memorySegment = $memorySegment;
        $this->location = $location;

        if (
            MemoryAccessAction::POP_ACTION()->getKey() === $this->memoryAccessAction->getKey() &&
            MemorySegment::CONSTANT_SEGMENT()->getKey() === $this->memorySegment->getKey()
        ) {
            throw new \LogicException('Cannot put value to constant segment!');
        }
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
        $convertor = new SegmentToAssemblerNameConvertor();
        $memorySegmentsWithOffsets = [
            MemorySegment::LOCAL_SEGMENT()->getKey(),
            MemorySegment::ARGUMENT_SEGMENT()->getKey(),
            MemorySegment::THIS_SEGMENT()->getKey(),
            MemorySegment::THAT_SEGMENT()->getKey(),
        ];
        $stubReplacer
            ->replace('SEGMENT_LOCATION', $convertor->convert($this->memorySegment, $this->currentFileName, $this->location));

        if (in_array($this->memorySegment->getKey(), $memorySegmentsWithOffsets)) {
            $segmentAccess = 'M';

            if ($this->location === 1) {
                $segmentAccess = 'M+1';
            } elseif ($this->location > 1) {
                $segmentAccess = $this->location;
            }

            return $stubReplacer
                ->replace($this->location > 1 ? 'SEGMENT_OFFSET' : 'SEGMENT_ACCESS', $segmentAccess)
                ->handle(
                    sprintf(
                        $this->location <= 1 ? '%sStack.stub' : '%sWithLargerOffsetStack.stub',
                        ucfirst($this->memoryAccessAction->getValue())
                    )
                );
        }

        return $stubReplacer
            ->replace(
                'SEGMENT_RECEIVER',
                MemorySegment::CONSTANT_SEGMENT()->getValue() === $this->memorySegment->getValue() ? 'A' : 'M'
            )
            ->handle(
                sprintf('%sAltStack.stub', ucfirst($this->memoryAccessAction->getValue()))
            );
    }

    public function setFile(string $filename): VMCommandWithFileKnowledge
    {
        $this->currentFileName = $filename;

        return $this;
    }

    public function getFile(): string
    {
        return $this->currentFileName;
    }
}
