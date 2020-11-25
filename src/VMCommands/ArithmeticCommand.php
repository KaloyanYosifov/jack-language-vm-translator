<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Converter\Convertor;
use JackVMTranslator\Replacers\StubReplacer;
use JackVMTranslator\Enums\AlgorithmicAction;

class ArithmeticCommand implements VMCommand
{
    protected AlgorithmicAction $action;

    public function __construct(AlgorithmicAction $action)
    {
        $this->action = $action;
    }

    public function getAction(): AlgorithmicAction
    {
        return $this->action;
    }

    public function getVMCode(): string
    {
        return sprintf(
            '%s',
            $this->action->getValue()
        );
    }

    public function getAssemblerCode(StubReplacer $stubReplacer): string
    {
        static $labelIndex = 0;
        $arithmeticStubMap = [
            AlgorithmicAction::ADD_ACTION()->getKey() => 'arithmetic/Add.stub',
            AlgorithmicAction::SUB_ACTION()->getKey() => 'arithmetic/Sub.stub',
            AlgorithmicAction::NEG_ACTION()->getKey() => 'arithmetic/Neg.stub',
            AlgorithmicAction::EQ_ACTION()->getKey() => 'arithmetic/Eq.stub',
            AlgorithmicAction::GT_ACTION()->getKey() => 'arithmetic/Gt.stub',
            AlgorithmicAction::LT_ACTION()->getKey() => 'arithmetic/Lt.stub',
            AlgorithmicAction::AND_ACTION()->getKey() => 'arithmetic/And.stub',
            AlgorithmicAction::OR_ACTION()->getKey() => 'arithmetic/Or.stub',
            AlgorithmicAction::NOT_ACTION()->getKey() => 'arithmetic/Not.stub',
        ];

        return $stubReplacer
            ->replace('LABEL_INDEX', $labelIndex++)
            ->handle($arithmeticStubMap[$this->action->getKey()]);
    }
}
