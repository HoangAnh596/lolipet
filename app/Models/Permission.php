<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';

    /**
     * 31/8
     * HungTM
     * start
     */
    public function role_has_permission(){
        return $this->hasMany(RoleHasPermission::class, 'permission_id');
    }
    /**
     * 31/8
     * HungTM
     * end
     */
}
