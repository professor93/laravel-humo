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
        public string               $pan,
        public string               $expiry,
        public string               $pan2,
        public string               $amount,
        public string               $ccy_code,
        public string               $merchant_id,
        public string               $terminal_id,
        public string|Optional|null $internal_pan_masked = null,
        public string|Optional|null $internal_pan2_masked = null,
        public string|Optional|null $fld_126_P2PR = null,
        public string|Optional|null $amount_fee = null,
        public string|Optional|null $merchant_name = null,
        public string|Optional|null $point_code = null,
        public string|Optional|null $transaction_amount = null,
        public string|Optional|null $cardholder_amount = null,
        public string|Optional|null $cardholder_ccy_code = null,
        public string|Optional|null $conversion_rate = null,
        public string|Optional|null $auth_action_code = null,
        public string|Optional|null $auth_action_code_final = null,
        public string|Optional|null $auth_appr_code = null,
        public string|Optional|null $auth_ref_number = null,
        public string|Optional|null $auth_stan = null,
        public string|Optional|null $auth_time = null,
        public string|Optional|null $stip_client_id = null,
        public string|Optional|null $card_type = null,
        public string|Optional|null $acq_inst = null,
        public string|Optional|null $auth_row_numb1 = null,
        public string|Optional|null $reconcile_info = null,
        public string|Optional|null $iss_ref_data = null,
        public string|Optional|null $auth_action_code2 = null,
        public string|Optional|null $auth_appr_code2 = null,
        public string|Optional|null $auth_ref_number2 = null,
        public string|Optional|null $auth_stan2 = null,
        public string|Optional|null $auth_time2 = null,
        public string|Optional|null $card_type2 = null,
        public string|Optional|null $merchant_name2 = null,
        public string|Optional|null $acq_inst2 = null,
        public string|Optional|null $auth_row_numb3 = null,
        public string|Optional|null $reconcile_info2 = null,
        public string|Optional|null $iss_ref_data2 = null,
        public string|Optional|null $auth_msg_ref1 = null,
        public string|Optional|null $auth_msg_ref3 = null,
    )
    {
    }
}

