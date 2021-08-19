<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbEntity extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function columns()
    {
        return $this->hasMany(DbColumn::class, 'db_entity_id', 'id');
    }

    public function database()
    {
        return $this->belongsTo(Db::class, 'database_id', 'id');
    }
}
