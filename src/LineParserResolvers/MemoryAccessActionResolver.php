<?php

namespace JackVMTranslator\LineParserResolvers;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\Enums\MemoryAccessAction;
use JackVMTranslator\VMCommands\MemoryAccessCommand;
use JackVMTranslator\Exceptions\InvalidMemorySegmentException;
use JackVMTranslator\Exceptions\InvalidMemoryAccessActionException;

class MemoryAccessActionResolver implements LineParserResolver
{
    public function handle(array $lineInParts): ?VMCommand
    {
        if (count($lineInParts) !== 3) {
            return null;
        }

        $location = $lineInParts[2];

        if (!$memoryAccessAction = MemoryAccessAction::search($lineInParts[0])) {
            throw new InvalidMemoryAccessActionException($lineInParts[0]);
        }

        if (!$memorySegment = MemorySegment::search($lineInParts[1])) {
            throw new InvalidMemorySegmentException($lineInParts[1]);
        }

        return new MemoryAccessCommand(
            MemoryAccessAction::{$memoryAccessAction}(),
            MemorySegment::{$memorySegment}(),
            $location,
            basename(stream_get_meta_data($this->file)['uri'])
        );
    }
}