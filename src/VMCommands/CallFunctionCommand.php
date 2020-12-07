<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Replacers\StubReplacer;

class CallFunctionCommand implements VMCommand, VMCommandWithFileKnowledge
{
    protected string $fileName;
    protected string $functionName;
    protected int $numberOfArguments;

    public function __construct(string $functionName, int $numberOfArguments)
    {
        $this->fileName = '';
        $this->functionName = $functionName;
        $this->numberOfArguments = $numberOfArguments;
    }

    public function getVMCode(): string
    {
        return sprintf(
            'call %s %d',
            $this->functionName,
            $this->numberOfArguments
        );
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        static $calledFunctionsIndex = 0;
        $assemblyForArgumentsSubtractingTheCurrentSpPointer = '';

        if ($this->numberOfArguments > 0) {
            $assemblyForArgumentsSubtractingTheCurrentSpPointer = '@' . $this->numberOfArguments . PHP_EOL;
            $assemblyForArgumentsSubtractingTheCurrentSpPointer .= 'D=D+A';
        }

        return $stubReplacer
            ->replace('CALLER_RETURN_ADDRESS', $this->fileName . '$ret' . $calledFunctionsIndex++)
            ->replace('CALLED_FUNCTION_NAME', $this->functionName)
            ->replace('ARGUMENTS_SUBTRACTION', $assemblyForArgumentsSubtractingTheCurrentSpPointer)
            ->handle('CallFunction.stub');
    }

    public function setFile(string $filename): VMCommandWithFileKnowledge
    {
        $this->fileName = $filename;

        return $this;
    }

    public function getFile(): string
    {
        return $this->fileName;
    }
}