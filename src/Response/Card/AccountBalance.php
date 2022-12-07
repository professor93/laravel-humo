<?php
/**
 * Date: 10/3/2022
 * Time: 3:11 PM
 */

namespace Uzbek\LaravelHumo\Response\Card;

use Uzbek\LaravelHumo\Response\BaseResponse;

class AccountBalance extends BaseResponse
{
    private ?Card $_card = null;

    private ?Balance $_balance = null;

    private ?Account $_account = null;

    public function __construct(array $attributes)
    {
        parent::__construct($attributes['getCardAccountsBalanceResponse'] ?? []);
    }

    public function getCard(): Card
    {
        if ($this->_card === null) {
            $this->_card = new Card($this->getAttribute('card', []));
        }

        return $this->_card;
    }

    public function getBalance(): Balance
    {
        if ($this->_balance === null) {
            $this->_balance = new Balance($this->getAttribute('balance', []));
        }

        return $this->_balance;
    }

    public function getAccount(): Account
    {
        if ($this->_account === null) {
            $this->_account = new Account($this->getAttribute('account', []));
        }

        return $this->_account;
    }
}
