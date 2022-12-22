<?php

namespace Uzbek\LaravelHumo\Response\Middle;

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
