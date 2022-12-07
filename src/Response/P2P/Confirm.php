<?php
/**
 * Date: 8/24/2022
 * Time: 6:39 PM
 */

namespace Uzbek\LaravelHumo\Response\P2P;

use Uzbek\LaravelHumo\Response\BaseResponse;
use Uzbek\LaravelHumo\Response\Payment\ConfirmDetails;

/**
 * Class P2PConfirm
 *
 * @property-read string paymentID
 * @property-read ConfirmDetails details
 * @property-read string action
 */
class Confirm extends BaseResponse
{
    private ConfirmDetails|null $_details = null;

    public function __construct(array $params)
    {
        parent::__construct($params['PaymentResponse'] ?? []);
    }

    public function getDetails(): ConfirmDetails
    {
        if ($this->_details === null) {
            $details = $this->getAttribute('details', []);
            $items = $details['item'] ?? [];

            $this->_details = new ConfirmDetails($this->getFormattedItems($items));
        }

        return $this->_details;
    }
}
