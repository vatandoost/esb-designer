<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbColumn extends Model
{
    use HasFactory;

    public function entity()
    {
        return $this->belongsTo(DbEntity::class, 'db_entity_id', 'id');
    }
}
