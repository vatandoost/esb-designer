<?php

namespace App\Statics;

class FunctionType
{
    const TYPE_DB = 'db';
    const TYPE_REST = 'rest';
    const TYPE_SOAP = 'soap';
    const TYPE_BLENDED = 'blended';

    public static function labels()
    {
        return [
            self::TYPE_DB => 'Database',
            self::TYPE_REST => 'Restful API',
            self::TYPE_SOAP => 'SOAP API',
            self::TYPE_BLENDED => 'Blended',
        ];
    }
}
