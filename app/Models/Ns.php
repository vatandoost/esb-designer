<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ns extends Model
{
    use HasFactory;
    
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected $table = "namespaces";

    public function vaiables()
    {
        return $this->morphMany(Variable::class, 'object');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'namespace_id', 'id');
    }

    public function functions()
    {
        return $this->hasMany(Func::class, 'namespace_id', 'id');
    }
}
