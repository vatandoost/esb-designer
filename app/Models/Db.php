<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Db extends Model
{
    use HasFactory;

    public function entities()
    {
        return $this->hasMany(DbEntity::class, 'database_id', 'id');
    }

    public function functions()
    {
        return $this->hasMany(DbFunc::class, 'database_id', 'id');
    }
}