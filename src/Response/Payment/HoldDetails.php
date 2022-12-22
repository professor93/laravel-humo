<?php
/**
 * Date: 9/29/2022
 * Time: 12:34 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Spatie\LaravelData\Data;

class HoldDetails extends Data
{
    public function __construct(
        public string $pan,
        public string $expiry,
        public string $ccy_code,
        public string $amount,
        public string $merchant_id,
        public string $terminal_id,
        public string $point_code,
        public string $centre_id,
    )
    {
    }
}
