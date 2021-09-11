<?php

namespace App\Statics;

class FieldType
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_DOUBLE = 'double';
    const TYPE_ARRAY_OBJECT = 'array_of_object';
    const TYPE_ARRAY_STRING = 'array_of_string';
    const TYPE_ARRAY_NUMBER = 'array_of_number';
    const TYPE_OBJECT = 'object';
    const TYPE_BOOLEAN = 'bool';

    public static function labels()
    {
        return [
            self::TYPE_BOOLEAN => 'Boolean',
            self::TYPE_STRING => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_DOUBLE => 'Double',
            self::TYPE_ARRAY_OBJECT => 'Array of object',
            self::TYPE_ARRAY_STRING => 'Array of string',
            self::TYPE_ARRAY_NUMBER => 'Array of number',
            self::TYPE_OBJECT => 'Object'
        ];
    }
    public static function operators()
    {
        return [
            self::TYPE_BOOLEAN => [
                Operators::TYPE_EQ => [self::TYPE_BOOLEAN],
                Operators::TYPE_NEQ => [self::TYPE_BOOLEAN],
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
            ],
            self::TYPE_STRING => [
                Operators::TYPE_EQ => [self::TYPE_STRING],
                Operators::TYPE_NEQ => [self::TYPE_STRING],
                Operators::TYPE_MATCH_REGX => [self::TYPE_STRING],
                Operators::TYPE_NOT_MATCH_REGX => [self::TYPE_STRING],
                Operators::TYPE_CONTAIN => [self::TYPE_STRING],
                Operators::TYPE_NOT_CONTAIN => [self::TYPE_STRING],
                Operators::TYPE_START_WITH => [self::TYPE_STRING],
                Operators::TYPE_NOT_START_WITH => [self::TYPE_STRING],
                Operators::TYPE_END_WITH => [self::TYPE_STRING],
                Operators::TYPE_NOT_END_WITH => [self::TYPE_STRING],
                Operators::TYPE_IN => [self::TYPE_ARRAY_STRING],
                Operators::TYPE_NOT_IN => [self::TYPE_ARRAY_STRING],
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
                Operators::TYPE_EMPTY => null,
                Operators::TYPE_NOT_EMPTY => null,
            ],
            self::TYPE_INTEGER => [
                Operators::TYPE_GT => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_GTE => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_EQ => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_NEQ => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_LT => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_LTE => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_IN => [self::TYPE_ARRAY_NUMBER],
                Operators::TYPE_NOT_IN => [self::TYPE_ARRAY_NUMBER],
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
            ],
            self::TYPE_DOUBLE => [
                Operators::TYPE_GT => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_GTE => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_EQ => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_NEQ => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_LT => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_LTE => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_IN => [self::TYPE_ARRAY_NUMBER],
                Operators::TYPE_NOT_IN => [self::TYPE_ARRAY_NUMBER],
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
            ],
            self::TYPE_ARRAY_STRING => [
                Operators::TYPE_INCLUDE => [self::TYPE_STRING],
                Operators::TYPE_NOT_INCLUDE => [self::TYPE_STRING],
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
                Operators::TYPE_EMPTY => null,
                Operators::TYPE_NOT_EMPTY => null,
            ],
            self::TYPE_ARRAY_NUMBER => [
                Operators::TYPE_INCLUDE => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_NOT_INCLUDE => [self::TYPE_INTEGER, self::TYPE_DOUBLE],
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
                Operators::TYPE_EMPTY => null,
                Operators::TYPE_NOT_EMPTY => null,
            ],
            self::TYPE_ARRAY_OBJECT => [
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
            ],
            self::TYPE_OBJECT => [
                Operators::TYPE_IS_NULL => null,
                Operators::TYPE_IS_NOT_NULL => null,
            ]
        ];
    }
}
