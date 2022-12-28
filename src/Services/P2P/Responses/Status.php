<?php
/**
 * Date: 8/24/2022
 * Time: 6:06 PM
 */

namespace Uzbek\LaravelHumo\Services\P2P\Responses;

use Spatie\LaravelData\Data;
use Uzbek\LaravelHumo\Services\Payment\Responses\Details;

class Status extends Data
{
    public function __construct(
        public string  $paymentID,
        public string  $paymentRef,
        public string  $status,
        public Details $details,
    )
    {
    }
}


