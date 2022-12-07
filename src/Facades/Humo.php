<?php

namespace Uzbek\LaravelHumo\Facades;

use Illuminate\Support\Facades\Facade;
use Uzbek\LaravelHumo\LaravelHumo;

/**
 * @see \Uzbek\LaravelHumo\LaravelHumo
 */
class Humo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LaravelHumo::class;
    }
}
