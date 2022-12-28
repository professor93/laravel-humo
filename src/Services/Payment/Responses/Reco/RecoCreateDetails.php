<?php
/**
 * Date: 9/29/2022
 * Time: 12:34 PM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses\Reco;

use Spatie\LaravelData\Data;

class RecoCreateDetails extends Data
{
    public function __construct(
        public string $terminal_id,
        public string $ttl,
        public string $ttl_action,
    )
    {
    }
}
