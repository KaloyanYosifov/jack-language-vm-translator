<?php

namespace JackVMTranslator;

use JackVMTranslator\VMCommands\VMCommand;
use JackVMTranslator\LineParserResolvers\BranchingResolver;
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

        /**
         * @var LineParserResolver $resolver
         */
        foreach ($this->resolvers as $resolver) {
            if ($command) {
                break;
            }

            $command = $resolver->handle($lineInParts);
        }

        return $command;
    }
}