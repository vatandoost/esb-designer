<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ns extends Model
{
    use HasFactory;

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
