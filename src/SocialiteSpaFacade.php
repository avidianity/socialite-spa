<?php

namespace Avidianity\SocialiteSpa;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void redirect(string $provider, string $token = null)
 * @method static mixed retrieve()
 * @see \Avidianity\SocialiteSpa\SocialiteSpa
 */
class SocialiteSpaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'socialite-spa';
    }
}
