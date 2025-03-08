<?php

namespace Khayrullin\KeycloakWebGuard\Auth\Guard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Khayrullin\KeycloakWebGuard\Auth\KeycloakAccessToken;
use Khayrullin\KeycloakWebGuard\Exceptions\KeycloakCallbackException;
use Khayrullin\KeycloakWebGuard\Facades\KeycloakWeb;
use Illuminate\Contracts\Auth\UserProvider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class KeycloakWebGuard implements Guard
{
    /**
     * @var null|Authenticatable
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return (bool) $this->user();
    }

    public function hasUser()
    {
        return (bool) $this->user();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (empty($this->user)) {
            $this->authenticate();
        }

        return $this->user;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(?Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        $user = $this->user();
        return $user->id ?? null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     *
     * @throws BadMethodCallException
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['access_token']) || empty($credentials['id_token'])) {
            return false;
        }

        /**
         * Store the section
         */
        $credentials['refresh_token'] = $credentials['refresh_token'] ?? '';
        KeycloakWeb::saveToken($credentials);

        return $this->authenticate();
    }

    /**
     * Try to authenticate the user
     *
     * @throws KeycloakCallbackException
     * @return boolean
     */
    public function authenticate()
    {
        // Get Credentials
        $credentials = KeycloakWeb::retrieveToken();
        if (empty($credentials)) {
            return false;
        }

        $user = KeycloakWeb::getUserProfile($credentials);
        if (empty($user)) {
            KeycloakWeb::forgetToken();

            return false;
        }

        // Provide User
        $user = $this->provider->retrieveByCredentials($user);

        $this->setUser($user);

        return true;
    }

    /**
     * Check user is authenticated and return his resource roles
     *
     * @param string $resource Default is empty: point to client_id
     *
     * @return array
     */
    public function roles($resource = '')
    {
        if (empty($resource)) {
            $resource = Config::get('keycloak-web.client_id');
        }

        $accessType = $resource == 'realm' ? 'realm_access' : 'resource_access';

        if (!$this->check()) {
            return false;
        }

        $token = KeycloakWeb::retrieveToken();

        if (empty($token) || empty($token['access_token'])) {
            return false;
        }

        $token = new KeycloakAccessToken($token);
        $token = $token->parseAccessToken();

        $resourceRoles = $token[$accessType] ?? [];
        if ($resource != 'realm') {
            $resourceRoles = $resourceRoles[$resource] ?? [];
        }
        $resourceRoles = $resourceRoles['roles'] ?? [];
        return $resourceRoles;
    }

    /**
     * Check user has a role
     *
     * @param array|string $roles
     * @param string $resource Default is empty: point to client_id
     *
     * @return boolean
     */
    public function hasRole($roles, $resource = '')
    {
        return empty(array_diff((array) $roles, $this->roles($resource)));
    }

    /**
     * Check user permissions for resource
     *
     * @param string $permissions
     * @return bool
     */
    public function hasPermissions($permissions)
    {
        return KeycloakWeb::obtainPermissions($permissions);
    }

    /**
     * Attempt to authenticate using HTTP Basic Auth.
     *
     * @param  string  $field
     * @param  array  $extraConditions
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function basic($field = 'email', $extraConditions = [])
    {
        if ($this->tryBasicAuth()) {
            return;
        }

        throw new UnauthorizedHttpException('Basic', 'Invalid credentials.');
    }

    public function tryBasicAuth()
    {
        if (!$this->request->getUser()) {
            return false;
        }

        $token = KeycloakWeb::getAccessTokenByPassword($this->request->getUser(), $this->request->getPassword());

        if (empty($token)) {
            return false;
        }

        $user = KeycloakWeb::getUserProfile($token);

        if (empty($user)) {
            return false;
        }

        $user = $this->provider->retrieveByCredentials($user);
        $this->setUser($user);
        return true;
    }
}
