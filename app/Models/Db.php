<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Db extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function entities()
    {
        return $this->hasMany(DbEntity::class, 'database_id', 'id');
    }

    public function functions()
    {
        return $this->hasMany(DbFunc::class, 'database_id', 'id');
    }
}
