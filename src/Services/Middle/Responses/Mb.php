<?php

namespace Uzbek\LaravelHumo\Services\Middle\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Mb extends Data
{
    public function __construct(
        public string          $state,
        public string|Optional $phone,
        public string          $message,
    )
    {
    }
}
