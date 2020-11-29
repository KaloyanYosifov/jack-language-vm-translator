<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Support\Helpers;
use JackVMTranslator\Enums\ArithmeticAction;
use JackVMTranslator\Replacers\StubReplacer;

class FunctionCommand implements VMCommand
{
    protected string $functionName;
    protected int $numberOfLocalVariables;

    public function __construct(string $functionName, int $numberOfLocalVariables)
    {
        $this->functionName = $functionName;
        $this->numberOfLocalVariables = $numberOfLocalVariables;
    }

    public function getVMCode(): string
    {
        return sprintf(
            'function %s %d',
            $this->functionName,
            $this->numberOfLocalVariables
        );
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        ob_start();
        ?>
        (<?php echo $this->functionName; ?>)
        <?php
        if ($this->numberOfLocalVariables > 0) {
            for ($i = 0; $i < $this->numberOfLocalVariables; $i++) {
                echo 'push constant 0' . PHP_EOL;
                echo 'pop local ' . $i . PHP_EOL;
            }
        }
        ?>
        <?php
        return Helpers::cleanOB(ob_get_clean());
    }
}