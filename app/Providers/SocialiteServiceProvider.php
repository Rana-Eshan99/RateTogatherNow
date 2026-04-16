<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Apple\AppleExtendSocialite;


class SocialiteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Socialite::extend('apple', function ($app) {
            $config = $app['config']['services.apple'];
            return Socialite::buildProvider(AppleExtendSocialite::class, $config);
        });
    }
}