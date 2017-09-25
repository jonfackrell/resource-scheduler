<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles{

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role)
    {
        $this->roles()->sync(
            Role::whereName($role)->firstOrFail()
        );

    }

    public function hasRole($role)
    {
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();

    }

    /**
     * Get the user role.
     */
    public function getRoleAttribute()
    {
        return \DB::table('role_user')->join('roles', 'roles.id' , '=', 'role_user.role_id')->whereUserId($this->getKey())->first();
    }

}
