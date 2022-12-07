<?php
/**
 * Date: 9/29/2022
 * Time: 12:34 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class Server
 *
 * @property-read int|null paymentID
 * @property-read array|null details
 */
class RecoCreate extends BaseResponse
{
    public function __construct(array $params)
    {
        parent::__construct($params['PaymentResponse'] ?? []);
    }

    public function isOk(): bool
    {
        return $this->paymentID !== null;
    }
}
