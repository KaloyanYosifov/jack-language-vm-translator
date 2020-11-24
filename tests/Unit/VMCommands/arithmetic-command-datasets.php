<?php

use JackVMTranslator\Enums\AlgorithmicAction;

dataset('arithmetic_command_tests', [
    [
        AlgorithmicAction::ADD_ACTION(),
        'arithmetic/Add.stub',
    ],
    [
        AlgorithmicAction::SUB_ACTION(),
        'arithmetic/Sub.stub',
    ],
    [
        AlgorithmicAction::EQ_ACTION(),
        'arithmetic/Eq.stub',
    ],
    [
        AlgorithmicAction::GT_ACTION(),
        'arithmetic/Gt.stub',
    ],
    [
        AlgorithmicAction::LT_ACTION(),
        'arithmetic/Lt.stub',
    ],
    [
        AlgorithmicAction::AND_ACTION(),
        'arithmetic/And.stub',
    ],
    [
        AlgorithmicAction::OR_ACTION(),
        'arithmetic/Or.stub',
    ],
    [
        AlgorithmicAction::NOT_ACTION(),
        'arithmetic/Not.stub',
    ],
]);