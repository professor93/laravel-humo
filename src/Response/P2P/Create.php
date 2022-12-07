<?php
/**
 * Date: 8/23/2022
 * Time: 1:15 PM
 */

namespace Uzbek\LaravelHumo\Response\P2P;

use Uzbek\LaravelHumo\Response\BaseResponse;

class Create extends BaseResponse
{
    public function __construct(array $params)
    {
        parent::__construct($params['RequestResponse'] ?? []);
    }
}
