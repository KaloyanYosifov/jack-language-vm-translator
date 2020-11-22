<?php

namespace JackVMTranslator;

use JackVMTranslator\Exceptions\FileExtensionIsNotVM;
use JackVMTranslator\Exceptions\FileNotFoundException;

class Parser
{
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

    public function close(): void
    {
        if (!$this->file) {
            return;
        }

        fclose($this->file);
    }
}
