<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'record_status',
    ];

    //IN [FK]

    //OUT [PK]
    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'role_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
