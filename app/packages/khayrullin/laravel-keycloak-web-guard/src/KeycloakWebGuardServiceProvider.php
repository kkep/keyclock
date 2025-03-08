<?php

namespace Khayrullin\KeycloakWebGuard;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Khayrullin\KeycloakWebGuard\Auth\Guard\KeycloakWebGuard;
use Khayrullin\KeycloakWebGuard\Auth\KeycloakWebUserProvider;
use Khayrullin\KeycloakWebGuard\Services\KeycloakService;

class KeycloakWebGuardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Configuration
        $config = __DIR__ . '/../config/keycloak-web.php';

        $this->publishes([$config => config_path('keycloak-web.php')], 'config');
        $this->mergeConfigFrom($config, 'keycloak-web');

        // User Provider
        Auth::provider('keycloak-users', function($app, array $config) {
            return new KeycloakWebUserProvider($app['hash'], $config['model']);
        });

        Gate::define('keycloak-role', function ($user, $roles, $resource = '') {
            return $user->hasRole($roles, $resource) ?: null;
        });

        Gate::define('keycloak-permission', function ($user, $permissions) {
            return $user->hasPermissions($permissions) ?: null;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Keycloak Web Guard
        Auth::extend('keycloak-web', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider']);
            return new KeycloakWebGuard($provider, $app->request);
        });

        // Facades
        $this->app->bind('keycloak-web', function($app) {
            return $app->make(KeycloakService::class);
        });

        $this->registerRoutes();

        // Bind for client data
        $this->app->when(KeycloakService::class)->needs(ClientInterface::class)->give(function() {
            return new Client(Config::get('keycloak-web.guzzle_options', []));
        });
    }

    /**
     * Register the authentication routes for keycloak.
     *
     * @return void
     */
    private function registerRoutes()
    {
        $defaults = [
            'login' => 'login',
            'logout' => 'logout',
            'register' => 'register',
            'callback' => 'callback',
        ];

        $routes = Config::get('keycloak-web.routes', []);
        $routes = array_merge($defaults, $routes);

        // Register Routes
        $router =  $this->app->make('router');

        if (!empty($routes['login'])) {
            $router->middleware('web')->get(
                $routes['login'],
                '\Khayrullin\KeycloakWebGuard\Controllers\AuthController@login'
            )->name('login');
        }

        if (!empty($routes['logout'])) {
            $router->middleware('web')->get(
                $routes['logout'],
                '\Khayrullin\KeycloakWebGuard\Controllers\AuthController@logout'
            )->name('logout');
        }

        if (!empty($routes['register'])) {
            $router->middleware('web')->get(
                $routes['register'],
                '\Khayrullin\KeycloakWebGuard\Controllers\AuthController@register'
            )->name('register');
        }

        if (!empty($routes['callback'])) {
            $router->middleware('web')->get(
                $routes['callback'],
                '\Khayrullin\KeycloakWebGuard\Controllers\AuthController@callback'
            )->name('callback');
        }
    }
}
