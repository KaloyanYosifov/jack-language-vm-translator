<?php

namespace JackVMTranslator\Converter;

use JackVMTranslator\Enums\MemorySegment;

class SegmentToAssemblerNameConvertor implements Convertor
{
    protected array $convertedNames = [];

    public function __construct()
    {
        $this->convertedNames = [
            MemorySegment::LOCAL_SEGMENT()->getKey() => 'LCL',
            MemorySegment::ARGUMENT_SEGMENT()->getKey() => 'ARG',
            MemorySegment::THIS_SEGMENT()->getKey() => 'THIS',
            MemorySegment::THAT_SEGMENT()->getKey() => 'THAT',
        ];
    }

    public function convert(MemorySegment $memorySegment, string $currentFileName, int $location): string
    {
        if (array_key_exists($memorySegment->getKey(), $this->convertedNames)) {
            return $this->convertedNames[$memorySegment->getKey()];
        }

        if (MemorySegment::TEMP_SEGMENT()->getKey() === $memorySegment->getKey()) {
            $offsetedLocation = $location + 5;

            if ($offsetedLocation > 12) {
                throw new \LogicException('Temporary variable out of scope!');
            }

            return 'R' . $offsetedLocation;
        }

        if (MemorySegment::STATIC_SEGMENT()->getKey() === $memorySegment->getKey()) {
            return pathinfo($currentFileName, PATHINFO_FILENAME) . '.' . $location;
        }

        if (MemorySegment::CONSTANT_SEGMENT()->getKey() === $memorySegment->getKey()) {
            return $location;
        }

        if (MemorySegment::POINTER_SEGMENT()->getKey() === $memorySegment->getKey()) {
            if ($location !== 0 && $location !== 1) {
                throw new \LogicException('Pointer out of scope, please use 1 or 0.');
            }

            return [
                0 => 'THIS',
                1 => 'THAT',
            ][$location];
        }
    }
}