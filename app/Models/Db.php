<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Db extends Model
{
    use HasFactory;

    const TYPE_MYSQL = 1;
    const TYPE_PGSQL = 2;
    const TYPE_SQLSERVER = 3;

    public static function types()
    {
        return [
            self::TYPE_MYSQL => 'Mysql',
            self::TYPE_PGSQL => 'Postgresql',
            self::TYPE_SQLSERVER => 'SqlServer',
        ];
    }

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected $table = "databases";

    protected $fillable = ['name', 'type', 'host', 'db', 'port', 'username', 'password', 'schema'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function namespace()
    {
        return $this->belongsTo(Ns::class, 'namespace_id', 'id');
    }

    public function entities()
    {
        return $this->hasMany(DbEntity::class, 'database_id', 'id');
    }

    public function functions()
    {
        return $this->hasMany(DbFunc::class, 'database_id', 'id');
    }
}
