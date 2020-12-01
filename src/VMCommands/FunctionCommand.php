<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\LineParser;
use JackVMTranslator\Support\Helpers;
use JackVMTranslator\Enums\ArithmeticAction;
use JackVMTranslator\Replacers\StubReplacer;
use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\Retrievers\StubFileRetriever;

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
            $lineParser = new LineParser();

            for ($i = 0; $i < $this->numberOfLocalVariables; $i++) {
                echo $lineParser->parse('push constant 0')->getAssemblerCode(new StubReplacerService(new StubFileRetriever()));
                echo $lineParser->parse('pop local ' . $i)->getAssemblerCode(new StubReplacerService(new StubFileRetriever()));
            }
        }
        ?>
        <?php
        return Helpers::cleanOB(ob_get_clean());
    }
}