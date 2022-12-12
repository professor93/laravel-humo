<?php

namespace Uzbek\LaravelHumo\Response\Middle;

use Spatie\LaravelData\Data;

class Mb extends Data
{
    public function __construct(
        public string $state,
        public string $phone,
        public string $message,
    )
    {
    }
}

