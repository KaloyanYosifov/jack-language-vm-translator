<?php

namespace JackVMTranslator\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static ArithmeticAction ADD_ACTION()
 * @method static ArithmeticAction SUB_ACTION()
 * @method static ArithmeticAction NEG_ACTION()
 * @method static ArithmeticAction EQ_ACTION()
 * @method static ArithmeticAction GT_ACTION()
 * @method static ArithmeticAction LT_ACTION()
 * @method static ArithmeticAction AND_ACTION()
 * @method static ArithmeticAction OR_ACTION()
 * @method static ArithmeticAction NOT_ACTION()
 */
class ArithmeticAction extends Enum
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
