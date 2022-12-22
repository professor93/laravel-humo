<?php
/**
 * Date: 9/30/2022
 * Time: 3:11 PM
 */

namespace Uzbek\LaravelHumo\Services;

use Uzbek\LaravelHumo\Exceptions\{AccessGatewayException, ClientException, ConnectionException, Exception, TimeoutException};
use Uzbek\LaravelHumo\Response\AccessGateway\SmsStatus;

class AccessGateway extends BaseService
{
    /**
     * @param $holder_id
     * @param $bank_id
     * @return SmsStatus
     *
     * @throws ClientException
     * @throws ConnectionException
     * @throws TimeoutException
     * @throws AccessGatewayException
     * @throws Exception
     */
    public function smsStatus($holder_id, $bank_id): SmsStatus
    {
        $session_id = $this->getSessionID();
        $xml = view('humo::access_gateway.sms_status', compact('holder_id', 'bank_id'))->renderMin();

        return new SmsStatus($this->sendXmlRequest('smsStatus', $xml));
    }

    /**
     * @param string $holderName
     * @param string $holderID
     * @param string $card_number
     * @param string $card_expiry
     * @param string $phone
     * @return bool
     *
     * @throws AccessGatewayException
     * @throws ClientException
     * @throws ConnectionException
     * @throws Exception
     * @throws TimeoutException
     */
    public function smsOn(string $holderName, string $holderID, string $card_number, string $card_expiry, string $phone): bool
    {
        $bank_c = substr($card_number, 4, 2);
        $xml = view('humo::access_gateway.sms_on', compact('holderName', 'holderID', 'card_number', 'card_expiry', 'phone', 'bank_c'))->renderMin();
        $result = $this->sendXmlRequest('smsOn', $xml);

        if (isset($result['importResponse']) && is_array($result['importResponse'])) {
            return empty($result['importResponse']);
        }

        return false;
    }
}
