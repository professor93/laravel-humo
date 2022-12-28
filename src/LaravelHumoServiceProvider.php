<?php

namespace Uzbek\LaravelHumo;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\View\View;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelHumoServiceProvider extends PackageServiceProvider
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         */
        $package->name('laravel-humo')->hasConfigFile('humo')->hasViews('humo');
        $this->app->singleton(LaravelHumo::class, static fn() => new LaravelHumo(app(Repository::class), app(Factory::class)));
    }

    public function packageRegistered()
    {
        $conf = config('humo');
        $this->package->sharesDataWithAllViews('originator', $conf['username']);
        $this->package->sharesDataWithAllViews('centre_id', $conf['centre_id']);
        $this->package->sharesDataWithAllViews('point_code', $conf['point_code']);
        $this->package->sharesDataWithAllViews('ccy_code', LaravelHumo::CCY_CODE_UZS);
    }

    public function bootingPackage()
    {
        PendingRequest::macro('xMethod', function (string $method) {
            $this->options['headers']['X-Request-Method'] = $method;
            return $this;
        });

        Response::macro('xml', function () {
            $body = str_ireplace(['soap-env:', 'ag:', 'iiacs:', 'soapenv:', 'ns1:', 'ebppif1:'], '', mb_convert_encoding($this->body(), 'UTF-8', 'UTF-8'));
            return json_decode(json_encode(simplexml_load_string($body), JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
        });

        View::macro('renderMin', fn() => trim(str_replace('> <', '><', preg_replace('/\s+/', ' ', (string)$this->render()))));
    }
}
