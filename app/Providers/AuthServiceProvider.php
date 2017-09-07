<?php

namespace App\Providers;

use App\Models\Department;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Department::class => DepartmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {

        if(Schema::hasTable('users')) {

            Gate::before(function($user) {
                if($user->isSuperUser()) {
                    return true;
                }
            });
        }

        $this->registerPolicies();

        if(Schema::hasTable('permissions') && Schema::hasTable('roles')) {
            foreach ($this->getPermissions() as $permission){
                $gate->define($permission->name, function($user) use ($permission){
                    return $user->hasRole($permission->roles);
                });
            }
        }

    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
