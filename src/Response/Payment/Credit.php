<?php
/**
 * Date: 8/24/2022
 * Time: 6:06 PM
 */

namespace Uzbek\LaravelHumo\Response\Payment;

use Uzbek\LaravelHumo\Response\BaseResponse;

class Credit extends BaseResponse
{
    private Details|null $_details = null;

    public function __construct(array $params)
    {
        parent::__construct($params['PaymentResponse'] ?? []);
    }

    public function getDetails(): Details
    {
        if ($this->_details === null) {
            $details = $this->getAttribute('details', []);
            $items = $details['item'] ?? [];

            $this->_details = new Details($this->getFormattedItems($items));
        }

        return $this->_details;
    }
}
