<?php

namespace App\Statics;

class Operators
{
    const TYPE_GT = 'gt';
    const TYPE_GTE = 'gte';
    const TYPE_EQ = 'eq';
    const TYPE_NEQ = 'neq';
    const TYPE_LT = 'lt';
    const TYPE_LTE = 'lte';
    const TYPE_MATCH_REGX = 'reg';
    const TYPE_NOT_MATCH_REGX = 'nreg';
    const TYPE_CONTAIN = 'ct';
    const TYPE_NOT_CONTAIN = 'nct';
    const TYPE_START_WITH = 'sw';
    const TYPE_NOT_START_WITH = 'nsw';
    const TYPE_END_WITH = 'ew';
    const TYPE_NOT_END_WITH = 'new';
    const TYPE_INCLUDE = 'inc';
    const TYPE_NOT_INCLUDE = 'ninc';
    const TYPE_IN = 'in';
    const TYPE_NOT_IN = 'nin';
    const TYPE_IS_NULL = 'isn';
    const TYPE_IS_NOT_NULL = 'isnn';
    const TYPE_EMPTY = 'em';
    const TYPE_NOT_EMPTY = 'nem';

    public static function labels()
    {
        return [
            self::TYPE_GT => 'greater',
            self::TYPE_GTE => 'greater or equal',
            self::TYPE_EQ => 'equal',
            self::TYPE_NEQ => 'not equal',
            self::TYPE_LT => 'less',
            self::TYPE_LTE => 'less or equal',
            self::TYPE_MATCH_REGX => 'match reqgex',
            self::TYPE_NOT_MATCH_REGX => 'doesn\'t match regex',
            self::TYPE_CONTAIN => 'contain',
            self::TYPE_NOT_CONTAIN => 'doesn\'t contain',
            self::TYPE_START_WITH => 'start with',
            self::TYPE_NOT_START_WITH => 'doesn\'t start with',
            self::TYPE_END_WITH => 'end with',
            self::TYPE_NOT_END_WITH => 'doesn\'t end with',
            self::TYPE_INCLUDE => 'include',
            self::TYPE_NOT_INCLUDE => 'doesn\'t include',
            self::TYPE_IN => 'in',
            self::TYPE_NOT_IN => 'not in',
            self::TYPE_IS_NULL => 'is null',
            self::TYPE_IS_NOT_NULL => 'is not null',
            self::TYPE_EMPTY => 'is empty',
            self::TYPE_NOT_EMPTY => 'is not empty',
        ];
    }
}
