<?php

namespace Uzbek\LaravelHumo;

use Illuminate\Http\Client\PendingRequest;
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
        $package->name('laravel-humo')->hasConfigFile('humo')->hasViews('humo');
        $this->app->singleton(LaravelHumo::class, static fn() => new LaravelHumo());
    }

    public function packageRegistered()
    {
        $this->package->sharesDataWithAllViews('originator', config('humo.username'));
        $this->package->sharesDataWithAllViews('centre_id', config('humo.centre_id'));
        $this->package->sharesDataWithAllViews('point_code', config('humo.point_code'));
    }

    public function bootingPackage()
    {
        PendingRequest::macro('xMethod', function (string $method) {
            $this->options['headers']['X-Request-Method'] = $method;
            return $this;
        });

        Response::macro('xml', function () {
            $body = $this->body();
            $body = str_ireplace(['soap-env:', 'ag:', 'iiacs:', 'soapenv:', 'ns1:', 'ebppif1:'], '', mb_convert_encoding($body, 'UTF-8', 'UTF-8'));
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            return json_decode($json, true);
        });
    }
}
