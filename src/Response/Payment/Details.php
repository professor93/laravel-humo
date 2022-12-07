<?php
/**
 * Date: 9/29/2022
 * Time: 12:34 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class Details
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
 */
class Details extends BaseResponse
{
}
