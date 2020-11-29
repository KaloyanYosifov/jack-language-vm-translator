<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Support\Helpers;
use JackVMTranslator\Enums\ArithmeticAction;
use JackVMTranslator\Replacers\StubReplacer;

class FunctionCommand implements VMCommand
{
    protected string $functionName;
    protected int $numberOfArguments;

    public function __construct(string $functionName, int $numberOfArguments)
    {
        $this->functionName = $functionName;
        $this->numberOfArguments = $numberOfArguments;
    }

    public function getVMCode(): string
    {
        return sprintf(
            'function %s %d',
            $this->functionName,
            $this->numberOfArguments
        );
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        ob_start();
        ?>
        (<?php echo $this->functionName; ?>)
        <?php
        if ($this->numberOfArguments > 0) {
            for ($i = 0; $i < $this->numberOfArguments; $i++) {
                echo 'push constant 0' . PHP_EOL;
                echo 'pop local ' . $i . PHP_EOL;
            }
        }
        ?>
        <?php
        return Helpers::cleanOB(ob_get_clean());
    }
}