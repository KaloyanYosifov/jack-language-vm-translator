<?php

namespace JackVMTranslator;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\LineParserResolvers\BranchingResolver;
use JackVMTranslator\Exceptions\CouldNotParseLineException;
use JackVMTranslator\LineParserResolvers\ArithmeticResolver;
use JackVMTranslator\LineParserResolvers\LineParserResolver;
use JackVMTranslator\LineParserResolvers\MemoryAccessActionResolver;

class LineParser
{
    protected array $resolvers = [];

    public function __construct()
    {
        $this->resolvers = [
            new ArithmeticResolver(),
            new BranchingResolver(),
            new MemoryAccessActionResolver(),
        ];
    }

    public function parse(string $line): VMCommand
    {
        $command = null;
        $lineInParts = explode(' ', $line);
        $lastException = null;

        /**
         * @var LineParserResolver $resolver
         */
        foreach ($this->resolvers as $resolver) {
            if ($command) {
                break;
            }

            try {
                $command = $resolver->handle($lineInParts);
            } catch (\Exception $exception) {
                $lastException = $exception;
            }
        }

        if (!$command && $lastException) {
            throw $lastException;
        }

        if (!$command) {
            throw new CouldNotParseLineException($line);
        }

        return $command;
    }
}