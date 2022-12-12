<?php
/**
 * Date: 8/24/2022
 * Time: 6:06 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Uzbek\LaravelHumo\Response\BaseResponse;

class Hold extends BaseResponse
{
    public function __construct(array $params)
    {
        parent::__construct($params['RequestResponse'] ?? []);
    }
}
