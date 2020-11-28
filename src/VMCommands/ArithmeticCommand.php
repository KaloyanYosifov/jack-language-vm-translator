<?php

namespace JackVMTranslator\VMCommands;

use JackVMTranslator\Replacers\StubReplacer;
use JackVMTranslator\Enums\ArithmeticAction;

class ArithmeticCommand implements VMCommand
{
    protected ArithmeticAction $action;

    public function __construct(ArithmeticAction $action)
    {
        $this->action = $action;
    }

    public function getAction(): ArithmeticAction
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
            ArithmeticAction::ADD_ACTION()->getKey() => 'arithmetic/Add.stub',
            ArithmeticAction::SUB_ACTION()->getKey() => 'arithmetic/Sub.stub',
            ArithmeticAction::NEG_ACTION()->getKey() => 'arithmetic/Neg.stub',
            ArithmeticAction::EQ_ACTION()->getKey() => 'arithmetic/Eq.stub',
            ArithmeticAction::GT_ACTION()->getKey() => 'arithmetic/Gt.stub',
            ArithmeticAction::LT_ACTION()->getKey() => 'arithmetic/Lt.stub',
            ArithmeticAction::AND_ACTION()->getKey() => 'arithmetic/And.stub',
            ArithmeticAction::OR_ACTION()->getKey() => 'arithmetic/Or.stub',
            ArithmeticAction::NOT_ACTION()->getKey() => 'arithmetic/Not.stub',
        ];

        return $stubReplacer
            ->replace('LABEL_INDEX', $labelIndex++)
            ->handle($arithmeticStubMap[$this->action->getKey()]);
    }
}
