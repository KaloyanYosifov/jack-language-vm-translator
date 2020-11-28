<?php

use JackVMTranslator\Enums\ArithmeticAction;

dataset('arithmetic_command_tests', [
    [
        ArithmeticAction::ADD_ACTION(),
        'arithmetic/Add.stub',
    ],
    [
        ArithmeticAction::SUB_ACTION(),
        'arithmetic/Sub.stub',
    ],
    [
        ArithmeticAction::EQ_ACTION(),
        'arithmetic/Eq.stub',
    ],
    [
        ArithmeticAction::GT_ACTION(),
        'arithmetic/Gt.stub',
    ],
    [
        ArithmeticAction::LT_ACTION(),
        'arithmetic/Lt.stub',
    ],
    [
        ArithmeticAction::AND_ACTION(),
        'arithmetic/And.stub',
    ],
    [
        ArithmeticAction::OR_ACTION(),
        'arithmetic/Or.stub',
    ],
    [
        ArithmeticAction::NOT_ACTION(),
        'arithmetic/Not.stub',
    ],
]);