<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Func extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    protected $table = 'functions';

    protected $casts = [
        'config' => 'array',
    ];

    public function ns()
    {
        return $this->belongsTo(Ns::class, 'namespace_id', 'id');
    }

    public function params()
    {
        return $this->hasMany(FuncParam::class, 'function_id', 'id');
    }

    public function adapters()
    {
        return $this->hasMany(Adapter::class, 'function_id', 'id');
    }
}
