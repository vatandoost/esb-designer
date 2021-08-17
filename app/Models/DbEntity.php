<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbEntity extends Model
{
    use HasFactory;

    public function columns()
    {
        $this->hasMany(DbColumn::class, 'db_entity_id', 'id');
    }

    public function database()
    {
        $this->belongsTo(Db::class, 'database_id', 'id');
    }
}
