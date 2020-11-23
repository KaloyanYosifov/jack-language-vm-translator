<?php

namespace JackVMTranslator\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static AlgorithmicAction ADD_ACTION()
 */
class AlgorithmicAction extends Enum
{
    private const ADD_ACTION = 'add';
    private const SUB_ACTION = 'sub';
    private const NEG_ACTION = 'neg';
    private const EQ_ACTION = 'eq';
    private const GT_ACTION = 'gt';
    private const LT_ACTION = 'lt';
    private const AND_ACTION = 'and';
    private const OR_ACTION = 'or';
    private const NOT_ACTION = 'not';
}
