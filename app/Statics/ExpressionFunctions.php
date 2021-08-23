<?php

namespace App\Statics;

class ExpressionFunctions
{

    public static function list()
    {
        return [
            'min' => [
                'name' => 'min',
                'help' => 'get minimum of list'
            ],
            'max' => [
                'name' => 'max',
                'help' => 'get maximum of list'
            ]
        ];
    }
}
