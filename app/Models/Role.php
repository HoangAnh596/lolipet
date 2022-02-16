<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'guard_name'
    ];

    public function model_has_role()
    {
        return $this->hasMany(ModelHasRole::class, 'role_id');
    }

    public function role_has_permission()
    {
        return $this->hasMany(RoleHasPermission::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function assign(Permission $permission) //Gives permission to a role.
    {
        return $this->permissions()->save($permission);
    }
}