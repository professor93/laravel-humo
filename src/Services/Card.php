<?php
/**
 * Date: 8/17/2022
 * Time: 4:32 PM
 */

namespace Uzbek\LaravelHumo\Services;

use Uzbek\LaravelHumo\Exceptions\ClientException;
use Uzbek\LaravelHumo\Exceptions\ConnectionException;
use Uzbek\LaravelHumo\Exceptions\Exception;
use Uzbek\LaravelHumo\Exceptions\TimeoutException;
use Uzbek\LaravelHumo\Response\Card\AccountBalance;
use Uzbek\LaravelHumo\Response\Card\Customer;
use Uzbek\LaravelHumo\Response\Card\Info;

class Card extends BaseService
{
    /**
     * @param string $card_number
     * @return AccountBalance
     *
     */
    public function accountBalance(string $card_number): AccountBalance
    {
        $xml = view('humo::card.balance', compact('card_number'))->render();
        return new AccountBalance($this->sendXmlRequest('getCardAccountsBalance', $xml)->xml());
    }

    /**
     * @param string $primaryAccountNumber
     * @param int $mbFlag
     * @return Info
     *
     * @throws \Uzbek\LaravelHumo\Exceptions\Exception
     */
    public function info(string $primaryAccountNumber, int $mbFlag)
    {
        $response = $this->sendRequest('json_info', 'post', '/v2/iiacs/card', [
            'primaryAccountNumber' => $primaryAccountNumber,
            'mb_flag' => $mbFlag,
        ]);

        if (isset($data['error'])) {
            $message = $data['error']['message'] ?? 'Unknown Humo Middleware error';
            $code = $data['error']['code'] ?? 10001;

            throw new Exception($message, $code);
        }
        $card = $data['result']['card'] ?? null;
        if ($card) {
            $statuses = $card['statuses']['item'] ?? [];
            $card_status = '';
            foreach ($statuses as $status) {
                if ($status['type'] == 'card') {
                    $card_status = [
                        'actionCode' => $status['actionCode'],
                        'actionDescription' => $status['actionDescription'],
                        'effectiveDate' => $status['effectiveDate'],
                    ];

                    break;
                }
            }

            $info = new Info([
                'count' => 2,
                'success' => 2,
                'fail' => 0,
                'records' => [
                    [
                        'status' => 'ok',
                        'index' => 0,
                        'data' => [
                            [
                                'card' => [
                                    'pan' => $card['primaryAccountNumber'],
                                    'expiry' => $card['expiry'],
                                    'institutionId' => $card['institutionId'],
                                    'nameOnCard' => $card['nameOnCard'],
                                    'cardholderId' => $card['cardUserId'],
                                    'statuses' => $card_status,
                                    'bank_c' => $card['bankC'],
                                    'pinTryCount' => $card['pinTryCount'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'status' => 'ok',
                        'index' => 1,
                        'data' => [
                            [
                                'mb_agreement' => [
                                    'description' => $card['mb']['message'] ?? '',
                                    'state' => $card['mb']['state'] ?? '',
                                    'phone' => $card['mb']['phone'] ?? '',
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            return $info;
        }

        throw new Exception('MBPM Error! ' . __LINE__);
    }

    public function infoV1(string $card_number)
    {
        return new Info($this->sendRequest('json_info', 'POST', '/v2/iiacs/card', [
            'primaryAccountNumber' => $card_number,
            'mb_flag' => 1,
        ]));
    }

    /**
     * @param $pan
     * @return mixed|null
     *
     * @throws ClientException
     * @throws ConnectionException
     * @throws TimeoutException
     */
    public function getMaskedPan($pan)
    {
        $res = $this->sendRequest('json_info', 'get', '/api/getMaskedPan', [
            'query' => [
                'pan' => $pan,
            ],]);

        return $res['masked_pan'] ?? null;
    }

    /**
     * @param $masked_pan
     * @return mixed|null
     *
     * @throws ClientException
     * @throws ConnectionException
     * @throws TimeoutException
     */
    public function getRealPan($masked_pan)
    {
        $res = $this->sendRequest('json_info', 'get', '/api/getRealPan', [
            'query' => [
                'masked_pan' => $masked_pan,
            ],
        ]);

        return $res['pan'] ?? null;
    }

    public function getConsumerList(string $phone, string $bankId = 'MB_STD'): Customer
    {
        return new Customer($this->sendRequest('json_info', 'POST', '/v2/mb/customer-list', [
            'phone' => $phone,
            'bankId' => $bankId,
        ]));
    }
}
