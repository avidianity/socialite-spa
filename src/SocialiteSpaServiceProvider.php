<?php

namespace Avidianity\SocialiteSpa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class SocialiteSpaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('socialite-spa.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'socialite-spa');

        $this->app->singleton('socialite-spa', function () {
            return new SocialiteSpa;
        });

        Route::middleware('socialite-spa')->group(function () {
            Route::get('/socialite-spa/{provider}/callback', function ($provider) {
                $key = config('socialite-spa.token_key', 'socialite_spa_token');
                if (Session::has($key)) {
                    $token = Session::get($key);
                    $user = Socialite::driver($provider)->stateless()->user();
                    Session::remove($key);
                    Cache::put($token, $user);
                }
                return '<script>window.close()</script>';
            });

            Route::get('/socialite-spa/retrieve', function (Request $request) {
                $key = config('socialite-spa.token_key', 'socialite_spa_token');
                if ($token = $request->input($key)) {
                    return [
                        'data' => Cache::get($token)
                    ];
                }

                return ['data' => null];
            });
        });
    }
}
