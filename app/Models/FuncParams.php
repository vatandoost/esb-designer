<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncParams extends Model
{
    use HasFactory;

    public function function()
    {
        return $this->belongsTo(Func::class, 'function_id', 'id');
    }
}
