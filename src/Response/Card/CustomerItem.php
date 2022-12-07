<?php
/**
 * Date: 10/5/2022
 * Time: 5:55 PM
 */

namespace Uzbek\LaravelHumo\Response\Card;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * @property string customerId
 * @property string bankId
 * @property string cardholderName
 * @property array  Card
 */
class CustomerItem extends BaseResponse
{
    /**
     * @var CustomerCard[]
     */
    public array $list = [];

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        foreach ($this->Card as $card) {
            $this->list[] = new CustomerCard($card);
        }
    }
}
