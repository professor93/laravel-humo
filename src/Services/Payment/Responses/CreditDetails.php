<?php
/**
 * Date: 8/24/2022
 * Time: 6:06 PM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreditDetails extends Data
{
    public function __construct(
        public string          $pan2,
        public string          $expiry,
        public string          $ccy_code,
        public string          $amount,
        public string          $merchant_id,
        public string          $terminal_id,
        public string          $point_code,
        public string          $centre_id,
        public string|Optional $sender_nationality,
        public string|Optional $sender_doc_type,
        public string|Optional $sender_serial_no,
        public string|Optional $sender_id_card,
        public string|Optional $sender_doc_validthrough,
        public string|Optional $sender_person_code,
        public string|Optional $sender_surname,
        public string|Optional $sender_first_name,
        public string|Optional $sender_middle_name,
        public string|Optional $sender_birth_date,
        public string|Optional $internal_pan2_masked,
        public string|Optional $check_sender_data3,
        public string|Optional $fld_126_MSSD,
        public string|Optional $auth_action_code,
        public string|Optional $auth_action_code_final,
        public string|Optional $auth_appr_code,
        public string|Optional $auth_ref_number,
        public string|Optional $auth_stan,
        public string|Optional $auth_time,
        public string|Optional $stip_client_id,
        public string|Optional $card_type,
        public string|Optional $merchant_name,
        public string|Optional $acq_inst,
        public string|Optional $auth_row_numb1,
        public string|Optional $reconcile_info,
        public string|Optional $iss_ref_data,
        public string|Optional $transaction_amount,
        public string|Optional $cardholder_amount,
        public string|Optional $cardholder_ccy_code,
        public string|Optional $conversion_rate,
    )
    {
    }
}
