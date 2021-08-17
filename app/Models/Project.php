<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function vaiables()
    {
        return $this->morphMany(Variable::class, 'object');
    }

    public function ns()
    {
        return $this->belongsTo(Ns::class, 'namespace_id', 'id');
    }

    public function runners()
    {
        $this->hasMany(Runner::class, 'project_id', 'id');
    }

    public function providers()
    {
        $this->hasMany(Provider::class, 'project_id', 'id');
    }
}
