<?php

namespace Avidianity\SocialiteSpa;

use Avidianity\SocialiteSpa\Exceptions\SocialiteSpaException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialiteSpa
{
    /**
     * @var string
     */
    protected $key;

    public function __construct()
    {
        $this->key = config('socialite-spa.token_key', 'socialite_spa_token');
    }

    /**
     * @param string $provider
     * @param string|null $token
     * @return void
     */
    public function redirect($provider, $token = null)
    {
        $validToken = $this->saveToken($token ?? request()->input($this->key));

        return Socialite::driver($provider)->with([$this->key => $validToken])->redirect();
    }

    /**
     * @return mixed
     */
    public function retrieve()
    {
        if (Cache::has($this->key)) {
            return Cache::get($this->key);
        }

        return null;
    }

    /**
     * @param string|null $token
     * @return string
     */
    protected function saveToken($token)
    {
        if (!$token) {
            throw new SocialiteSpaException('There is no token provided.');
        }

        Session::put($this->key, $token);

        return $token;
    }
}
