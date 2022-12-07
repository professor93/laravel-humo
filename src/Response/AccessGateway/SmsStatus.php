<?php
/**
 * Date: 9/30/2022
 * Time: 3:12 PM
 */

namespace Uzbek\LaravelHumo\Response\AccessGateway;

use Uzbek\LaravelHumo\Response\BaseResponse;

class SmsStatus extends BaseResponse
{
    private ?Charge $_charge = null;

    private ?Card $_card = null;

    private ?Phone $_phone = null;

    public function __construct(array $attributes)
    {
        parent::__construct($attributes['exportResponse'] ?? []);
    }

    public function getCharge(): Charge
    {
        if ($this->_charge === null) {
            $this->_charge = new Charge($this->getAttribute('Charge', []));
        }

        return $this->_charge;
    }

    public function getCard(): Card
    {
        if ($this->_card === null) {
            $this->_card = new Card($this->getAttribute('Card', []));
        }

        return $this->_card;
    }

    public function getPhone(): Phone
    {
        if ($this->_phone === null) {
            $this->_phone = new Phone($this->getAttribute('Phone', []));
        }

        return $this->_phone;
    }
}
