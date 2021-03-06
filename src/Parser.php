<?php

namespace JackVMTranslator;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\Exceptions\FileNotFoundException;
use JackVMTranslator\VMCommands\VMCommandWithFileKnowledge;
use JackVMTranslator\Exceptions\FileExtensionIsNotVMException;

class Parser
{
    private const MAX_LINE_LENGTH = 4096;
    protected $file = null;
    protected LineParser $lineParser;

    public function __construct(LineParser $lineParser)
    {
        $this->lineParser = $lineParser;
    }

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

            if (!$line) {
                continue;
            }

            $command = $this->lineParser->parse($line);

            if ($command instanceof VMCommandWithFileKnowledge) {
                $command->setFile(basename(stream_get_meta_data($this->file)['uri']));
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
