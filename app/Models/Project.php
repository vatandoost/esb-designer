<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected $fillable = ['name'];

    public function vaiables()
    {
        return $this->morphMany(Variable::class, 'object');
    }

    public function namespaces()
    {
        return $this->hasMany(Ns::class, 'project_id', 'id');
    }

    public function mainNamespace()
    {
        return $this->hasOne(Ns::class, 'main_namespace_id', 'id');
    }

    public function runners()
    {
        return $this->hasMany(Runner::class, 'project_id', 'id');
    }

    public function providers()
    {
        return $this->hasMany(Provider::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
