<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();
        Passport::routes();

        foreach ($this->getPermissions() as $permission) {

            $gate->define ($permission->slug, function ($user) use ($permission) {
                return  $user->hasRole($permission->roles);
            });
        }
    }

    protected function getPermissions()
    {
        try {
            return Permission::with('roles')->get();
        }catch (\Exception $e) {
            return [];
        }

    }
}
