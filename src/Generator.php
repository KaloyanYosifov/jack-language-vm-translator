<?php

namespace JackVMTranslator;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\Retrievers\StubFileRetriever;
use JackVMTranslator\Exceptions\FileNotFoundException;
use JackVMTranslator\Exceptions\FileExtensionIsNotVMException;

class Generator
{
    protected $file = null;

    /**
     * @param string $filename
     * @return $this
     * @throws FileExtensionIsNotVMException
     * @throws FileNotFoundException
     */
    public function open(string $filename): self
    {
        if (!preg_match('~\.asm$~', $filename)) {
            throw new FileExtensionIsNotVMException($filename);
        }

        $this->file = fopen($filename, 'a+');

        return $this;
    }

    public function writeCode(VMCommand $command)
    {
        fwrite(
            $this->file,
            $command->getAssemblerCode(new StubReplacerService(new StubFileRetriever())) . PHP_EOL
        );
    }

    public function close(): void
    {
        if (!$this->file) {
            return;
        }

        fclose($this->file);
    }
}