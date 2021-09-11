<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adapter extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected $casts = [
        'config' => 'array',
        'function_config' => 'array',
    ];

    protected $fillable = ['name', 'type', 'function_id', 'function_config', 'config'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function function()
    {
        return $this->belongsTo(Func::class, 'function_id', 'id');
    }
}
