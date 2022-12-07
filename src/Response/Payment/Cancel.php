<?php
/**
 * Date: 8/24/2022
 * Time: 6:59 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

class Cancel
{
    public bool $isOk = false;

    public function __construct(array $params)
    {
        $this->isOk = isset($params['CancelRequestResponse']);
    }
}
