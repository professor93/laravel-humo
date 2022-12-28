<?php
/**
 * Date: 9/29/2022
 * Time: 12:34 PM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Details extends Data
{
    public function __construct(
        public string          $pan,
        public string          $expiry,
        public string          $amount,
        public string          $merchant_id,
        public string          $terminal_id,
        public string          $point_code,
        public string          $centre_id,
        public string|Optional $ccy_code,
        public string|Optional $internal_pan_masked,
        public string|Optional $netsw_proccode,
        public string|Optional $sli,
        public string|Optional $cardholder_amount1a,
        public string|Optional $cardholder_ccy_code,
        public string|Optional $conversion_rate,
        public string|Optional $auth_action_code,
        public string|Optional $auth_action_code_final,
        public string|Optional $auth_appr_code,
        public string|Optional $auth_appr_code1a,
        public string|Optional $auth_ref_number,
        public string|Optional $auth_stan,
        public string|Optional $auth_stan1a,
        public string|Optional $auth_time,
        public string|Optional $stip_client_id,
        public string|Optional $card_type,
        public string|Optional $merchant_name,
        public string|Optional $acq_inst,
        public string|Optional $auth_row_numb1a,
        public string|Optional $ret_ref_numb1a,
        public string|Optional $reconcile_info,
        public string|Optional $amount1a,
        public string|Optional $amount1a_original,
        public string|Optional $iss_ref_data,
        public string|Optional $auth_msg_ref1a,
        public string|Optional $transaction_amount,
        public string|Optional $auth_row_numb1,
        public string|Optional $auth_msg_ref1,
    )
    {
    }
}

