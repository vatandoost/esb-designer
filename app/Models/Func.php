<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Func extends Model
{
    use HasFactory;

    public function ns()
    {
        return $this->belongsTo(Ns::class, 'namespace_id', 'id');
    }

    public function params()
    {
        return $this->hasMany(FuncParams::class, 'function_id', 'id');
    }
}
