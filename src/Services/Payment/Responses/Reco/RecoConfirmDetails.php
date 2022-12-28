<?php
/**
 * Date: 9/29/2022
 * Time: 12:34 PM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses\Reco;

use Spatie\LaravelData\Data;

class RecoConfirmDetails extends Data
{
    public function __construct(
        public string $terminal_id,
        public string $ttl,
        public string $ttl_action,
        public string $debits_number,
        public string $debits_amount,
        public string $credits_reversal_number,
        public string $credits_reversal_amount,
        public string $reconcile_info,
    )
    {
    }
}
