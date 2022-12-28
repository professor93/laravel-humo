<?php
/**
 * Date: 9/29/2022
 * Time: 12:35 PM
 */

namespace Uzbek\LaravelHumo\Services\Payment\Responses;

use Uzbek\LaravelHumo\Services\BaseResponse;

/**
 * Class ConfirmDetails
 *
 * @property-read string pan
 * @property-read string expiry
 * @property-read string ccy_code
 * @property-read string amount
 * @property-read string merchant_id
 * @property-read string terminal_id
 * @property-read string point_code
 * @property-read string centre_id
 * @property-read string internal_pan_masked
 * @property-read string transaction_amount
 * @property-read string cardholder_amount
 * @property-read string cardholder_ccy_code
 * @property-read string conversion_rate
 * @property-read string auth_action_code
 * @property-read string auth_appr_code
 * @property-read string auth_ref_number
 * @property-read string auth_stan
 * @property-read string auth_time
 * @property-read string stip_client_id
 * @property-read string card_type
 * @property-read string merchant_name
 * @property-read string acq_inst
 * @property-read string auth_row_numb1
 * @property-read string reconcile_info
 * @property-read string iss_ref_data
 * @property-read string auth_msg_ref1
 */
class ConfirmDetails extends BaseResponse
{
}
