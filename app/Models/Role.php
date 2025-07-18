<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}