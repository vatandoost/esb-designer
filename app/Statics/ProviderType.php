<?php

namespace App\Statics;

class ProviderType
{
    const TYPE_REST_API = 'rest';
    const TYPE_SOAP_API = 'soap';
    const TYPE_EMAIL = 'email';

    public static function labels()
    {
        return [
            self::TYPE_REST_API => 'Restful API Server',
            self::TYPE_SOAP_API => 'SOAP API Server',
            self::TYPE_EMAIL => 'Email Server',
        ];
    }
}
