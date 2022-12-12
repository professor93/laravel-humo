<?php

namespace Uzbek\LaravelHumo\Services;

use DateTime;
use Exception;
use Uzbek\LaravelHumo\Dtos\Middle\CardDto;
use Uzbek\LaravelHumo\Dtos\Middle\Dto;
use Uzbek\LaravelHumo\Dtos\Middle\PhoneDto;
use Uzbek\LaravelHumo\Dtos\Middle\Request\ChangePhoneRequest;
use Uzbek\LaravelHumo\Dtos\Middle\Request\CustomerActivateRequest;
use Uzbek\LaravelHumo\Dtos\Middle\Request\ScoringRequest;
use Uzbek\LaravelHumo\Dtos\Middle\Request\TransactionHistoryRequest;
use Uzbek\LaravelHumo\Response\Middle\CardInfo;

class Middle extends BaseService
{
    public function cardInfo($primaryAccountNumber, $mb_flag = true)
    {
        $resp = $this->sendRequest('/v3/iiacs/card', compact('primaryAccountNumber', 'mb_flag'));
        if (isset($resp['result'])) {
            return CardInfo::from($resp['result']);
        }
        throw new Exception('Card not found. [1256]', 1256);
    }

    private function sendRequest($url, $params)
    {
        if ($params instanceof Dto) $params = $params->toArray();
        $body = [
            'id' => $this->getNewSessionID(),
            'params' => $params,
        ];
        return $this->client->post($url, $body)->json();
    }

    public function customerActivate(string $pan, string $phone)
    {
        return $this->sendRequest('/v2/mb/customer/activate', new CustomerActivateRequest(new CardDto($pan), new PhoneDto($phone)));
    }

    public function customer(string $customerId, string|null $bankId = null)
    {
        $bankId ??= 'MB_STD';
        return $this->sendRequest('/v2/mb/customer', compact('customerId', 'bankId'));
    }

    public function customerList(string $phone, $bankId = 'MB_STD')
    {
        return $this->sendRequest('/v2/mb/customer-list', compact('phone', 'bankId'));
    }

    public function customerDeactivate($customerId)
    {
        return $this->sendRequest('/v2/mb/customer/deactivate', compact('customerId'));
    }

    public function customerChangePhone($customerId, $phone)
    {
        return $this->sendRequest('/v2/mb/customer/change-phone-number', new ChangePhoneRequest($customerId, new PhoneDto($phone)));
    }

    public function customerChangeCardholdersLang(string $customerId, string $language)
    {
        return $this->sendRequest('/v2/mb/customer/change-cardholders-message-lang', compact('customerId', 'language'));
    }

    public function customerRemoveCard(string $pan)
    {
        $Card = new CardDto($pan, []);
        return $this->sendRequest('/v2/mb/customer/remove-card', compact('Card'));
    }


    /**
     * Not implemented yet
     */
    public function customerEditCard($pan)
    {
        return $this->sendRequest('/v2/mb/customer/edit-card', []);
    }

    public function customerCardsByPassport($passport_seria, $passport_number)
    {
        return $this->sendRequest('/cs/v1/customer/cards/by-passport', [
            'serial_no' => $passport_seria,
            'id_card' => $passport_number,
        ]);
    }

    public function customerCardsByPinfl(string $pinfl)
    {
        return $this->sendRequest('/cs/v1/customer/cards/by-person-code', ['person_code' => $pinfl]);
    }

    /**
     * Not implemented yet
     */
    public function transactionsScoring(string $pan, DateTime $from, DateTime $to)
    {
        return $this->sendRequest('/cs/v1/transactions/scoring', new ScoringRequest($pan, $from, $to));
    }

    /**
     * Not implemented yet
     */
    public function setExchangeRates()
    {
        return $this->sendRequest('/v2/ccr2/exchange-rates', []);
    }

    public function transactionHistory(string $pan, DateTime $from, DateTime $to)
    {
        return $this->sendRequest('/v1/ws/transaction-history', new TransactionHistoryRequest($pan, $from, $to));
    }

    public function maskedPan($pan)
    {
        return $this->sendRequest('/v2/pm/masked-pan', compact('pan'));
    }

    public function realPan($maskedPan)
    {
        return $this->sendRequest('/v2/pm/real-pan', ['card' => $maskedPan]);
    }
}
