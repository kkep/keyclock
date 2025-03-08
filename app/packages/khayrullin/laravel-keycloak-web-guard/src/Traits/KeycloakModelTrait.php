<?php

namespace Khayrullin\KeycloakWebGuard\Traits;

use Illuminate\Support\Facades\Auth;

trait KeycloakModelTrait {

    /**
     * Check user has roles
     *
     * @see KeycloakWebGuard::hasRole()
     *
     * @param  string|array  $roles
     * @param  string  $resource
     * @return boolean
     */
    public function hasRole($roles, $resource = '')
    {
        return Auth::hasRole($roles, $resource);
    }

    /**
     * Check user has permissions
     *
     * @see KeycloakWebGuard::hasPermissions()
     *
     * @param  string  $permissions
     * @return boolean
     */
    public function hasPermissions($permissions)
    {
        return Auth::hasPermissions($permissions);
    }
}
