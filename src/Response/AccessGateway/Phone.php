<?php
/**
 * Date: 9/30/2022
 * Time: 5:25 PM
 */

namespace Uzbek\LaravelHumo\Response\AccessGateway;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class Phone
 *
 * @property-read string state
 * @property-read string|null msisdn
 * @property-read string deliveryChannel
 * @property-read string|null number
 */
class Phone extends BaseResponse
{
    public function getNumber()
    {
        if (preg_match('/^\+\d{12}$/', $this->msisdn) === 1) {
            return substr($this->msisdn, 1);
        }

        return $this->msisdn;
    }
}
