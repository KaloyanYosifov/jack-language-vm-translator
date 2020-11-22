<?php

namespace JackVMTranslator;

use JackVMTranslator\Exceptions\FileExtensionIsNotVM;
use JackVMTranslator\Exceptions\FileNotFoundException;

class Parser
{
    private const MAX_LINE_LENGTH = 4096;
    protected $file = null;

    /**
     * @param string $filename
     * @return $this
     * @throws FileExtensionIsNotVM
     * @throws FileNotFoundException
     */
    public function open(string $filename): self
    {
        if (!preg_match('~\.vm$~', $filename)) {
            throw new FileExtensionIsNotVM($filename);
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
            yield $line;
        }
    }

    public function close(): void
    {
        if (!$this->file) {
            return;
        }

        fclose($this->file);
    }
}
