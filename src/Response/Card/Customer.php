<?php

namespace Uzbek\LaravelHumo\Response\Card;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Date: 8/17/2022
 * Time: 4:29 PM
 */
class Customer extends BaseResponse
{
    public array $list = [];

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        if (! empty($attributes['result']['Customer'])) {
            foreach ($attributes['result']['Customer'] as $item) {
                $this->list[] = new CustomerItem($item);
            }
        }
    }
}
