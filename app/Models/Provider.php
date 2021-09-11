<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
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
    ];

    protected $fillable = ['name', 'type', 'config'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
