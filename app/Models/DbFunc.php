<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbFunc extends Model
{
    use HasFactory;

    public function database()
    {
        return $this->belongsTo(Db::class, 'database_id', 'id');
    }
}
