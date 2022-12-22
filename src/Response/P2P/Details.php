<?php
/**
 * Date: 9/29/2022
 * Time: 12:34 PM
 */

namespace Uzbek\LaravelHumo\Response\P2P;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Details extends Data
{
    public function __construct(
        public string          $pan,
        public string          $expiry,
        public string          $pan2,
        public string          $amount,
        public string          $ccy_code,
        public string          $merchant_id,
        public string          $terminal_id,
        public string|Optional $internal_pan_masked,
        public string|Optional $internal_pan2_masked,
        public string|Optional $fld_126_P2PR,
        public string|Optional $amount_fee,
        public string|Optional $merchant_name,
        public string|Optional $point_code,
        public string|Optional $transaction_amount,
        public string|Optional $cardholder_amount,
        public string|Optional $cardholder_ccy_code,
        public string|Optional $conversion_rate,
        public string|Optional $auth_action_code,
        public string|Optional $auth_action_code_final,
        public string|Optional $auth_appr_code,
        public string|Optional $auth_ref_number,
        public string|Optional $auth_stan,
        public string|Optional $auth_time,
        public string|Optional $stip_client_id,
        public string|Optional $card_type,
        public string|Optional $acq_inst,
        public string|Optional $auth_row_numb1,
        public string|Optional $reconcile_info,
        public string|Optional $iss_ref_data,
        public string|Optional $auth_action_code2,
        public string|Optional $auth_appr_code2,
        public string|Optional $auth_ref_number2,
        public string|Optional $auth_stan2,
        public string|Optional $auth_time2,
        public string|Optional $card_type2,
        public string|Optional $merchant_name2,
        public string|Optional $acq_inst2,
        public string|Optional $auth_row_numb3,
        public string|Optional $reconcile_info2,
        public string|Optional $iss_ref_data2,
        public string|Optional $auth_msg_ref1,
        public string|Optional $auth_msg_ref3,
    )
    {
    }
}

