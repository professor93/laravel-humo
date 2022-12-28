<?php
/**
 * Date: 8/24/2022
 * Time: 6:06 PM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses;

use Spatie\LaravelData\Data;

class Hold extends Data
{
    public function __construct(
        public string      $language,
        public string      $switchingID,
        public string      $autoSwitch,
        public string      $paymentRef,
        public string      $paymentOriginator,
        public HoldDetails $details,
    )
    {
    }
}
