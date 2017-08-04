<?php

namespace App\Traits;

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

}
