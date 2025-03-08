<?php

namespace Khayrullin\KeycloakWebGuard\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Config;

/**
 * @method static getLoginUrl()
 * @method static getLogoutUrl()
 * @method static getAccessToken(string $code)
 * @method static getUserProfile(array $credentials)
 * @method static forgetToken()
 */
class KeycloakWeb extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'keycloak-web';
    }
}
