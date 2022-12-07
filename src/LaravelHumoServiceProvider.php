<?php

namespace Uzbek\LaravelHumo;

use Illuminate\Http\Client\Response;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelHumoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         */
        $package->name('laravel-humo')->hasConfigFile()->hasViews('humo');
        $this->app->singleton(LaravelHumo::class, static fn() => new LaravelHumo(config('humo')));
    }

    public function packageRegistered()
    {
        $this->package->sharesDataWithAllViews('originator', config('humo.username'));
    }

    public function bootingPackage()
    {
        Response::macro('xml', function () {
            $body = $this->body();
            $body = str_ireplace(['soap-env:', 'ag:', 'iiacs:', 'soapenv:', 'ns1:', 'ebppif1:'], '', mb_convert_encoding($body, 'UTF-8', 'UTF-8'));
            return simplexml_load_string($body);
        });
    }
}
