<?php

namespace JackVMTranslator;

use JackVMTranslator\Enums\MemorySegment;
use JackVMTranslator\Enums\MemoryAccessAction;
use JackVMTranslator\VMCommands\MemoryAccessCommand;
use JackVMTranslator\Exceptions\FileExtensionIsNotVMException;
use JackVMTranslator\Exceptions\FileNotFoundException;
use JackVMTranslator\Exceptions\InvalidMemorySegmentException;
use JackVMTranslator\Exceptions\InvalidMemoryAccessActionException;

class Parser
{
    private const MAX_LINE_LENGTH = 4096;
    protected $file = null;

    /**
     * @param string $filename
     * @return $this
     * @throws FileExtensionIsNotVMException
     * @throws FileNotFoundException
     */
    public function open(string $filename): self
    {
        if (!preg_match('~\.vm$~', $filename)) {
            throw new FileExtensionIsNotVMException($filename);
        }

        if (!file_exists($filename)) {
            throw new FileNotFoundException($filename);
        }

        $this->file = fopen($filename, 'r');

        return $this;
    }

    /**
     * @return \Generator
     */
    public function parseLine()
    {
        if (!$this->file) {
            throw new \LogicException('You haven\'t opened a VM file!');
        }

        while (($line = fgets($this->file, static::MAX_LINE_LENGTH)) !== false) {
            $line = $this->formatCodeLine($line);

            $parts = explode(' ', $line);

            if (count($parts) === 3) {
                $location = $parts[2];

                if (!$memoryAccessAction = MemoryAccessAction::search($parts[0])) {
                    throw new InvalidMemoryAccessActionException($parts[0]);
                }

                if (!$memorySegment = MemorySegment::search($parts[1])) {
                    throw new InvalidMemorySegmentException($parts[1]);
                }

                $command = new MemoryAccessCommand(
                    MemoryAccessAction::{$memoryAccessAction}(),
                    MemorySegment::{$memorySegment}(),
                    $parts[2]
                );
            } else {
                $command = 'test';
            }

            yield $command;
        }
    }

    public function close(): void
    {
        if (!$this->file) {
            return;
        }

        fclose($this->file);
    }

    protected function formatCodeLine(string $line): string
    {
        // remove comments from line
        if (($foundCommentPos = strpos($line, '//')) !== false) {
            $line = substr_replace($line, '', $foundCommentPos);
        }

        return trim($line);
    }
}
