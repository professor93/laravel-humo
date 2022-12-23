<?php
/**
 * Date: 8/24/2022
 * Time: 6:06 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreditDetails extends Data
{
    public function __construct(
        public string               $pan2,
        public string               $expiry,
        public string               $ccy_code,
        public string               $amount,
        public string               $merchant_id,
        public string               $terminal_id,
        public string               $point_code,
        public string               $centre_id,
        public string|Optional|null $sender_nationality = null,
        public string|Optional|null $sender_doc_type = null,
        public string|Optional|null $sender_serial_no = null,
        public string|Optional|null $sender_id_card = null,
        public string|Optional|null $sender_doc_validthrough = null,
        public string|Optional|null $sender_person_code = null,
        public string|Optional|null $sender_surname = null,
        public string|Optional|null $sender_first_name = null,
        public string|Optional|null $sender_middle_name = null,
        public string|Optional|null $sender_birth_date = null,
        public string|Optional|null $internal_pan2_masked = null,
        public string|Optional|null $check_sender_data3 = null,
        public string|Optional|null $fld_126_MSSD = null,
        public string|Optional|null $auth_action_code = null,
        public string|Optional|null $auth_action_code_final = null,
        public string|Optional|null $auth_appr_code = null,
        public string|Optional|null $auth_ref_number = null,
        public string|Optional|null $auth_stan = null,
        public string|Optional|null $auth_time = null,
        public string|Optional|null $stip_client_id = null,
        public string|Optional|null $card_type = null,
        public string|Optional|null $merchant_name = null,
        public string|Optional|null $acq_inst = null,
        public string|Optional|null $auth_row_numb1 = null,
        public string|Optional|null $reconcile_info = null,
        public string|Optional|null $iss_ref_data = null,
        public string|Optional|null $transaction_amount = null,
        public string|Optional|null $cardholder_amount = null,
        public string|Optional|null $cardholder_ccy_code = null,
        public string|Optional|null $conversion_rate = null,
    )
    {
    }
}
