<?php

namespace JackVMTranslator\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static AlgorithmicAction ADD_ACTION()
 * @method static AlgorithmicAction SUB_ACTION()
 * @method static AlgorithmicAction NEG_ACTION()
 * @method static AlgorithmicAction EQ_ACTION()
 * @method static AlgorithmicAction GT_ACTION()
 * @method static AlgorithmicAction LT_ACTION()
 * @method static AlgorithmicAction AND_ACTION()
 * @method static AlgorithmicAction OR_ACTION()
 * @method static AlgorithmicAction NOT_ACTION()
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
