<?php

namespace Uzbek\LaravelHumo\Services\Middle;

use DateTime;
use Exception;
use Uzbek\LaravelHumo\Dtos\Middle\CardDto;
use Uzbek\LaravelHumo\Dtos\Middle\Dto;
use Uzbek\LaravelHumo\Dtos\Middle\PhoneDto;
use Uzbek\LaravelHumo\Services\BaseService;
use Uzbek\LaravelHumo\Services\Middle\Requests\ChangePhoneRequest;
use Uzbek\LaravelHumo\Services\Middle\Requests\CustomerActivateRequest;
use Uzbek\LaravelHumo\Services\Middle\Requests\ScoringRequest;
use Uzbek\LaravelHumo\Services\Middle\Requests\TransactionHistoryRequest;
use Uzbek\LaravelHumo\Services\Middle\Responses\CardInfo;
use Uzbek\LaravelHumo\Services\Middle\Responses\TransactionHistory;

class MiddleService extends BaseService
{
    public function cardInfo($primaryAccountNumber, $mb_flag = true): CardInfo
    {
        $resp = $this->sendRequest('/v3/iiacs/card', ['primaryAccountNumber' => $primaryAccountNumber, 'mb_flag' => $mb_flag]);
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
        return $this->sendRequest('/v2/mb/customer', ['customerId' => $customerId, 'bankId' => $bankId]);
    }

    public function customerList(string $phone, $bankId = 'MB_STD')
    {
        return $this->sendRequest('/v2/mb/customer-list', ['phone' => $phone, 'bankId' => $bankId]);
    }

    public function customerDeactivate($customerId)
    {
        return $this->sendRequest('/v2/mb/customer/deactivate', ['customerId' => $customerId]);
    }

    public function customerChangePhone($customerId, $phone)
    {
        return $this->sendRequest('/v2/mb/customer/change-phone-number', new ChangePhoneRequest($customerId, new PhoneDto($phone)));
    }

    public function customerChangeCardholdersLang(string $customerId, string $language)
    {
        return $this->sendRequest('/v2/mb/customer/change-cardholders-message-lang', ['customerId' => $customerId, 'language' => $language]);
    }

    public function customerRemoveCard(string $pan)
    {
        $Card = new CardDto($pan, []);
        return $this->sendRequest('/v2/mb/customer/remove-card', ['Card' => $Card]);
    }


    /**
     * Not implemented yet
     */
    public function customerEditCard()
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
        $resp = $this->sendRequest('/v1/ws/transaction-history', new TransactionHistoryRequest($pan, $from, $to));
        return TransactionHistory::from($resp);
    }

    public function maskedPan($pan)
    {
        return $this->sendRequest('/v2/pm/masked-pan', ['pan' => $pan]);
    }

    public function realPan($maskedPan)
    {
        return $this->sendRequest('/v2/pm/real-pan', ['card' => $maskedPan]);
    }
}
