<?php

namespace JackVMTranslator;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\Retrievers\StubFileRetriever;
use JackVMTranslator\VMCommands\CallFunctionCommand;
use JackVMTranslator\Exceptions\FileNotFoundException;
use JackVMTranslator\VMCommands\InitializationCommand;
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
            $this->getAssemblyCodeFromCommand($command)
        );
    }

    public function close(): void
    {
        if (!$this->file) {
            return;
        }

        $fileName = stream_get_meta_data($this->file)['uri'];
        $content = file_get_contents(stream_get_meta_data($this->file)['uri']);

        fclose($this->file);

        // below we are calling the initialization code
        // which is prepended to the file

        // if we have a sys init function
        // add initialization code to call it
        if (preg_match('~(Sys.init)~', $content)) {
            $content = $this->getAssemblyCodeFromCommand(
                    (new CallFunctionCommand('Sys.init', 0))->setFile('InitializationCode')
                ) . $content;
        }

        $content = $this->getAssemblyCodeFromCommand(new InitializationCommand()) . $content;

        file_put_contents($fileName, $content);
    }

    protected function getAssemblyCodeFromCommand(VMCommand $command): string
    {
        return $command->getAssemblerCode(new StubReplacerService(new StubFileRetriever())) . PHP_EOL;
    }
}