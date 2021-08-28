<?php

namespace App\Statics;

class AdapterType
{
    const TYPE_HTTP = 1;
    const TYPE_JOB = 2;
    const TYPE_RABITMQ = 3;

    const TYPE_API_INPUT_HEADER = 'header';
    const TYPE_API_INPUT_BODY = 'body';
    const TYPE_API_INPUT_QUERY = 'query';
    const TYPE_API_INPUT_FILE = 'file';

    const TYPE_JOB_INPUT_BODY = 'body';
    const TYPE_RABITMQ_INPUT_BODY = 'body';

    public static $inputTypes = [
        self::TYPE_HTTP => [
            self::TYPE_API_INPUT_HEADER => 'Header',
            self::TYPE_API_INPUT_BODY => 'Body',
            self::TYPE_API_INPUT_QUERY => 'Query',
            self::TYPE_API_INPUT_FILE => 'Files',
        ],
        self::TYPE_JOB => [
            self::TYPE_JOB_INPUT_BODY => 'Body',
        ],
        self::TYPE_JOB => [
            self::TYPE_RABITMQ_INPUT_BODY => 'Body',
        ]
    ];


    public static function labels()
    {
        return [
            self::TYPE_HTTP => 'Http',
            self::TYPE_JOB => 'Cron job',
            self::TYPE_RABITMQ => 'Rabitmq',
        ];
    }

    public static function getInputTypes($type)
    {
        return self::$inputTypes[$type];
    }
}
