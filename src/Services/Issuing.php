<?php
/**
 * Date: 9/30/2022
 * Time: 5:32 PM
 */

namespace Uzbek\LaravelHumo\Services;

use DateTime;
use Uzbek\LaravelHumo\Exceptions\AccessGatewayException;
use Uzbek\LaravelHumo\Exceptions\ClientException;
use Uzbek\LaravelHumo\Exceptions\ConnectionException;
use Uzbek\LaravelHumo\Exceptions\Exception;
use Uzbek\LaravelHumo\Exceptions\TimeoutException;
use Uzbek\LaravelHumo\Response\Issuing\AddCardToStop;
use Uzbek\LaravelHumo\Response\Issuing\CardInfo;
use Uzbek\LaravelHumo\Response\Issuing\ExecuteTransaction;
use Uzbek\LaravelHumo\Response\Issuing\GetRealCard;
use Uzbek\LaravelHumo\Response\Issuing\RemoveCardFromStop;
use Uzbek\LaravelHumo\Response\Issuing\ResetPinCounter;
use Uzbek\LaravelHumo\Response\Issuing\TransactionHistory;

class Issuing extends BaseService
{
    public function queryCardInfo(string $card): CardInfo
    {
        $session_id = $this->getSessionID();
        $bank_c = substr($card, 4, 2);

        $xml = "<soapenv:Envelope
	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
	xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
	xmlns:bin=\"urn:IssuingWS/binding\">
	<soapenv:Header/>
	<soapenv:Body>
		<bin:queryCardInfo soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding\">
			<ConnectionInfo xsi:type=\"urn:OperationConnectionInfo\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<EXTERNAL_SESSION_ID xsi:type=\"xsd:string\">{$session_id}</EXTERNAL_SESSION_ID>
			</ConnectionInfo>
			<Parameters xsi:type=\"urn:RowType_QueryCardInfo_Request\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<CARD xsi:type=\"xsd:string\">{$card}</CARD>
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
			</Parameters>
		</bin:queryCardInfo>
	</soapenv:Body>
</soapenv:Envelope>";

        return new CardInfo($this->sendXmlRequest('8443', $xml, $session_id, 'queryCardInfo'));
    }

    public function transactionHistory(string $card, DateTime $beginDate, DateTime $endDate): array
    {
        $session_id = $this->getSessionID();
        $bank_c = substr($card, 4, 2);

        $begin_date = $beginDate->format('Y-m-d\T').'00:00:00';
        $end_date = $endDate->format('Y-m-d\T').'23:59:59';

        $xml = "<soapenv:Envelope
	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
	xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
	xmlns:bin=\"urn:IssuingWS/binding\">
	<soapenv:Header/>
	<soapenv:Body>
		<bin:queryTransactionHistory soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">
			<ConnectionInfo xsi:type=\"urn:OperationConnectionInfo\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<EXTERNAL_SESSION_ID xsi:type=\"xsd:string\">{$session_id}</EXTERNAL_SESSION_ID>
			</ConnectionInfo>
			<Parameters xsi:type=\"urn:RowType_TransactionHist_Request\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<CARD xsi:type=\"xsd:string\">{$card}</CARD>
				<BEGIN_DATE xsi:type=\"xsd:dateTime\">{$begin_date}</BEGIN_DATE>
				<END_DATE xsi:type=\"xsd:dateTime\">{$end_date}</END_DATE>
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<LOCKING_FLAG xsi:type=\"xsd:string\">1</LOCKING_FLAG>
			</Parameters>
		</bin:queryTransactionHistory>
	</soapenv:Body>
</soapenv:Envelope>";

        $history = $this->sendXmlRequest('8443', $xml, $session_id, 'transactionHistory');
        $res_code = (int) ($history['queryTransactionHistoryResponse']['ResponseInfo']['response_code'] ?? -1);
        if ($res_code === 0) {
            $data = $history['queryTransactionHistoryResponse']['Details']['row'] ?? [];

            if (is_array($data) && isset($data['item']) && count($data) === 1) {
                $data = [$data];
            }

            $objects = [];
            foreach ($data as $item) {
                $params = [];
                $tranhis = $item['item'] ?? [];
                foreach ($tranhis as $nv) {
                    if (isset($nv['name'])) {
                        if (is_array($nv['name']) && isset($nv['name'][0])) {
                            $key = $nv['name'][0];
                        } else {
                            $key = $nv['name'];
                        }

                        if (is_array($nv['value'])) {
                            $value = $nv['value'][0] ?? null;
                        } else {
                            $value = $nv['value'] ?? null;
                        }

                        $params[$key] = $value;
                    }
                }
                $objects[] = new TransactionHistory($params);
            }

            return $objects;
        } else {
            throw new Exception('Cannot connect to NMPC', 20002);
        }
    }

    public function execute_transaction(
        string $card,
        int $operation_id,
        int $amount,
        bool $isCredit
    ): ExecuteTransaction {
        $session_id = $this->getSessionID();
        $bank_c = substr($card, 4, 2);
        $slip_nr = substr($operation_id, -8);
        $batch_nr = date('ymd');
        $tran_date = date('Y-m-d\TH:i:s');

        if ($isCredit) {
            $payment_mode = 2;
            $tran_type = '11V';
        } else {
            $payment_mode = 3;
            $tran_type = '12V';
        }

        $xml = "<soapenv:Envelope
	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
	xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
	xmlns:bin=\"urn:IssuingWS/binding\">
	<soapenv:Header/>
	<soapenv:Body>
		<bin:executeTransaction soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">
			<ConnectionInfo xsi:type=\"urn:OperationConnectionInfo\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<EXTERNAL_SESSION_ID xsi:type=\"xsd:string\">{$session_id}</EXTERNAL_SESSION_ID>
			</ConnectionInfo>
			<Parameters xsi:type=\"urn:RowType_ExecTransaction_Request\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<PAYMENT_MODE xsi:type=\"xsd:string\">{$payment_mode}</PAYMENT_MODE>
				<CARD xsi:type=\"xsd:string\">{$card}</CARD>
				<TRAN_TYPE xsi:type=\"xsd:string\">{$tran_type}</TRAN_TYPE>
				<BATCH_NR xsi:type=\"xsd:string\">{$batch_nr}</BATCH_NR>
				<SLIP_NR xsi:type=\"xsd:string\">{$slip_nr}</SLIP_NR>
				<TRAN_CCY xsi:type=\"xsd:string\">UZS</TRAN_CCY>
				<TRAN_AMNT xsi:type=\"xsd:decimal\">{$amount}</TRAN_AMNT>
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<CHECK_DUPL>1</CHECK_DUPL>
				<TRAN_DATE_TIME>{$tran_date}</TRAN_DATE_TIME>
			</Parameters>
		</bin:executeTransaction>
	</soapenv:Body>
</soapenv:Envelope>";

        return new ExecuteTransaction($this->sendXmlRequest('8443', $xml, $session_id, 'execute_transaction'));
    }

    /**
     * @param  string  $card
     * @param  string  $reason
     * @return AddCardToStop
     *
     * @throws AccessGatewayException
     * @throws ClientException
     * @throws ConnectionException
     * @throws Exception
     * @throws TimeoutException
     */
    public function addCardToStop(string $card, string $reason = 'user block'): AddCardToStop
    {
        $bank_c = substr($card, 4, 2);
        $session_id = $this->getSessionID();

        $xml = "<soapenv:Envelope
	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
	xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
	xmlns:bin=\"urn:IssuingWS/binding\">
	<soapenv:Header/>
	<soapenv:Body>
		<bin:addCardToStop soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">
			<ConnectionInfo xsi:type=\"urn:OperationConnectionInfo\" xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<EXTERNAL_SESSION_ID xsi:type=\"xsd:string\">{$session_id}</EXTERNAL_SESSION_ID>
			</ConnectionInfo>
			<Parameters xsi:type=\"urn:RowType_AddCardToStopList_Request\" xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<CARD xsi:type=\"xsd:string\">{$card}</CARD>
				<STOP_CAUSE xsi:type=\"xsd:string\">B</STOP_CAUSE>
				<TEXT xsi:type=\"xsd:string\">{$reason}</TEXT>
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
			</Parameters>
		</bin:addCardToStop>
	</soapenv:Body>
</soapenv:Envelope>";

        return new AddCardToStop($this->sendXmlRequest('8443', $xml, $session_id, 'addCardToStop'));
    }

    /**
     * @param  string  $card
     * @param  string  $reason
     * @return RemoveCardFromStop
     *
     * @throws AccessGatewayException
     * @throws ClientException
     * @throws ConnectionException
     * @throws Exception
     * @throws TimeoutException
     */
    public function removeCardFromStop(string $card, string $reason = 'User unblock'): RemoveCardFromStop
    {
        $bank_c = substr($card, 4, 2);
        $session_id = $this->getSessionID();

        $xml = "<soapenv:Envelope
	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
	xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
	xmlns:bin=\"urn:IssuingWS/binding\">
	<soapenv:Header/>
	<soapenv:Body>
		<bin:removeCardFromStop soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">
			<ConnectionInfo xsi:type=\"urn:OperationConnectionInfo\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<EXTERNAL_SESSION_ID xsi:type=\"xsd:string\">{$session_id}</EXTERNAL_SESSION_ID>
			</ConnectionInfo>
			<Parameters xsi:type=\"urn:RowType_RemoveCardFromStop_Request\"
				xmlns:urn=\"urn:issuing_v_01_02_xsd\">
				<CARD xsi:type=\"xsd:string\">{$card}</CARD>
				<TEXT xsi:type=\"xsd:string\">{$reason}</TEXT>
				<BANK_C xsi:type=\"xsd:string\">{$bank_c}</BANK_C>
				<GROUPC xsi:type=\"xsd:string\">01</GROUPC>
				<STOP_CAUSE xsi:type=\"xsd:string\">0</STOP_CAUSE>
			</Parameters>
		</bin:removeCardFromStop>
	</soapenv:Body>
</soapenv:Envelope>";

        return new RemoveCardFromStop($this->sendXmlRequest('8443', $xml, $session_id, 'removeCardFromStop'));
    }

    /**
     * @param  string  $card_number
     * @return GetRealCard
     *
     * @throws AccessGatewayException
     * @throws ClientException
     * @throws ConnectionException
     * @throws Exception
     * @throws TimeoutException
     */
    public function getRealCard(string $card_number): GetRealCard
    {
        $bank_c = substr($card_number, 4, 2);
        $session_id = $this->getSessionID();

        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<SOAP-ENV:Envelope
SOAP-ENV:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\"
	xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\"
	xmlns:SOAP-ENC=\"http://schemas.xmlsoap.org/soap/encoding/\"
	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
	<SOAP-ENV:Body>
		<getRealCard>
			<ConnectionInfo>
				<BANK_C>{$bank_c}</BANK_C>
				<GROUPC>01</GROUPC>
				<EXTERNAL_SESSION_ID>{$session_id}</EXTERNAL_SESSION_ID>
			</ConnectionInfo>
			<Parameters>
				<CARD>{$card_number}</CARD>
			</Parameters>
		</getRealCard>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>";

        return new GetRealCard($this->sendXmlRequest('8443', $xml, $session_id, 'getRealCard'));
    }

    /**
     * @param  string  $card
     * @param  string  $expire
     * @param  string  $reason
     * @return ResetPinCounter
     *
     * @throws AccessGatewayException
     * @throws ClientException
     * @throws ConnectionException
     * @throws Exception
     * @throws TimeoutException
     */
    public function resetPINCounter(string $card, string $expire, string $reason = 'RESET BY OWNER'): ResetPinCounter
    {
        $bank_c = substr($card, 4, 2);
        $session_id = $this->getSessionID();

        $xml = "<soapenv:Envelope
                    xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/'
                    xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
                    xmlns:xsd='http://www.w3.org/2001/XMLSchema'>
                    <soapenv:Body>
                        <resetPINCounter>
                            <ConnectionInfo>
                                <BANK_C>{$bank_c}</BANK_C>
                                <GROUPC>01</GROUPC>
                                <EXTERNAL_SESSION_ID>{$session_id}</EXTERNAL_SESSION_ID>
                            </ConnectionInfo>
                            <Parameters>
                                <CARD></CARD>
                                <EXPIRY>{$expire}</EXPIRY>
                                <TEXT>{$reason}</TEXT>
                                <OFFLINE>1</OFFLINE>
                            </Parameters>
                        </resetPINCounter>
                    </soapenv:Body>
                </soapenv:Envelope>";

        return new ResetPinCounter($this->sendXmlRequest('8443', $xml, $session_id, 'resetPINCounter'));
    }
}
