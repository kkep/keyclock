<?php

return [
    /**
     * Keycloak Url
     *
     * Generally https://your-server.com/auth
     */
    'base_url' => env('KEYCLOAK_BASE_URL', ''),

    /**
     * Keycloak Realm
     *
     * Default is master
     */
    'realm' => env('KEYCLOAK_REALM', 'master'),

    /**
     * The Keycloak Server realm public key (string).
     *
     * @see Keycloak >> Realm Settings >> Keys >> RS256 >> Public Key
     */
    'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY', null),

    /**
     * Keycloak Client ID
     *
     * @see Keycloak >> Clients >> Installation
     */
    'client_id' => env('KEYCLOAK_CLIENT_ID', null),

    /**
     * Keycloak Client Secret
     *
     * @see Keycloak >> Clients >> Installation
     */
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET', null),

    /**
     * We can cache the OpenId Configuration
     * The result from /realms/{realm-name}/.well-known/openid-configuration
     *
     * @link https://www.keycloak.org/docs/3.2/securing_apps/topics/oidc/oidc-generic.html
     */
    'cache_openid' => env('KEYCLOAK_CACHE_OPENID', false),

    /**
     * Page to redirect after callback if there's no "intent"
     *
     * @see Khayrullin\KeycloakWebGuard\Controllers\AuthController::callback()
     */
    'redirect_url' => '/',

    /**
     * Page to redirect after logout
     *
     * @see Khayrullin\KeycloakWebGuard\Controllers\AuthController::logout()
     */
    'redirect_logout' => env('KEYCLOAK_REDIRECT_LOGOUT', '/'),

    /**
     * The routes for authenticate
     *
     * Accept a string as the first parameter of route() or false to disable the route.
     *
     * The routes will receive the name "{route}" and login/callback are required.
     * So, if you make it false, you shoul register a named 'login' route and extend
     * the Khayrullin\KeycloakWebGuard\Controllers\AuthController controller.
     */


    'routes' => [
        'login' => 'login',
        'logout' => 'logout',
        'register' => 'register',
        'callback' => 'callback',
    ],

    'sync_attributes' => [
        'keycloak_id' => 'sub',
        'email' => 'email',
        'name' => 'name',
    ],

    'keycloak_id_column' => 'keycloak_id',
    'username_column' => 'email',

    /**
    * GuzzleHttp Client options
    *
    * @link http://docs.guzzlephp.org/en/stable/request-options.html
    */
   'guzzle_options' => [],
];
