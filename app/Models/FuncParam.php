<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncParam extends Model
{
    use HasFactory;

    const DIR_TYPE_IN = 0;
    const DIR_TYPE_OUT = 1;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    protected $table = 'function_params';

    public static function dir_types()
    {
        return [
            self::DIR_TYPE_IN => 'In',
            self::DIR_TYPE_OUT => 'Out',
        ];
    }

    public function function()
    {
        return $this->belongsTo(Func::class, 'function_id', 'id');
    }

    protected $casts = [
        'formula' => 'array',
    ];
}
