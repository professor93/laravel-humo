<?php
/**
 * Date: 9/30/2022
 * Time: 5:33 PM
 */

namespace Uzbek\LaravelHumo\Response\Issuing;

use DateTime;
use Uzbek\LaravelHumo\DateHelper;
use Uzbek\LaravelHumo\Exceptions\Exception;
use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class CardInfo
 *
 * @property-read string PVV_2
 * @property-read string STATUS2
 * @property-read string PVV_1
 * @property-read string U_COD10
 * @property-read string CHIP_APP_ID
 * @property-read string CARD_NUM
 * @property-read string CSC4_1
 * @property-read string COND_SET
 * @property-read string CRD_HOLD_MSG
 * @property-read string U_FIELD13
 * @property-read string DKI_1
 * @property-read string CSC5_2
 * @property-read string RENEW1_DATE
 * @property-read string U_FIELD14
 * @property-read string EXPIRITY2
 * @property-read string MIDLE_NAME
 * @property-read string U_FIELD8
 * @property-read string RENEW_STOP_CAUSE
 * @property-read string BASE_SUPP
 * @property-read string COMBI_ID
 * @property-read string CARD_SUFIKS
 * @property-read string EXPIRY1
 * @property-read string RENEW_DATE
 * @property-read string CSC5_1
 * @property-read string HINT_QUESTION
 * @property-read string RISK_LEVEL
 * @property-read string DKI_0
 * @property-read string CARD_TYPE
 * @property-read string CARD_SERVICES_SET
 * @property-read string PVKI_1
 * @property-read string CARD_NAME
 * @property-read string CLIENT_ID
 * @property-read string LAST_SEQ_NR
 * @property-read string CL_ROLE
 * @property-read string PVV2_1
 * @property-read string STOP_CAUSE
 * @property-read string CSC4_2
 * @property-read string U_FIELD7
 * @property-read string RENEWED_CARD
 * @property-read string U_FIELD11
 * @property-read string STOPLIST_TEXT
 * @property-read string WALLET_TYPE
 * @property-read string DESIGN_ID
 * @property-read string STATUS_CHANGE_DATE
 * @property-read string U_COD9
 * @property-read string SURNAME
 * @property-read string HINT_ANSWER
 * @property-read string RENEW
 * @property-read string CMPG_NAME
 * @property-read string F_NAMES
 * @property-read string CVC2_1
 * @property-read string PVKI_2
 * @property-read string RENEW_COMMENT
 * @property-read string REC_DATE
 * @property-read string CVC2_2
 * @property-read string CARD
 * @property-read string GROUPC
 * @property-read string SEQUENCE_NR
 * @property-read string F_NAME1
 * @property-read string PIN_FLAG
 * @property-read string PVV_COUNT_1
 * @property-read string U_FIELD12
 * @property-read string MC_NAME
 * @property-read string PVV2_2
 * @property-read string M_NAME
 * @property-read string BANK_C
 * @property-read string CTIME
 * @property-read string LAST_ACTIVITY_DATE
 * @property-read string PVV_COUNT_2
 * @property-read string DKI_2
 * @property-read string STATUS1
 * @property-read string RENEW_STATUS1
 * @property-read string CVC1_2
 * @property-read string CVC1_1
 * @property-read bool isCardExpired
 */
class CardInfo extends BaseResponse
{
    public function __construct(array $params)
    {
        $res_code = (int) ($params['queryCardInfoResponse']['ResponseInfo']['response_code'] ?? -1);
        if ($res_code === 0) {
            $data = $params['queryCardInfoResponse']['Details']['row']['item'] ?? [];
            $info = [];

            foreach ($data as $item) {
                if (isset($item['name'])) {
                    if (is_array($item['name']) && isset($item['name'][0])) {
                        $key = $item['name'][0];
                    } else {
                        $key = $item['name'];
                    }

                    if (is_array($item['value'])) {
                        $value = $item['value'][0] ?? null;
                    } else {
                        $value = $item['value'] ?? null;
                    }

                    $info[$key] = $value;
                }
            }

            parent::__construct($info);
        } else {
            throw new Exception('Cannot connect to NMPC', 20002);
        }
    }

    /**
     * @return DateTime
     *
     * @throws Exception
     */
    public function expiryDate(): DateTime
    {
        $expiry = DateHelper::expiry_date_from_string('Y-m-d\TH:i:s', $this->EXPIRY1);
        if ($expiry === false) {
            throw new Exception('Невалидный формат даты: '.$this->EXPIRY1);
        }

        return $expiry;
    }

    /**
     * @return bool
     *
     * @throws Exception
     */
    public function getIsCardExpired(): bool
    {
        return DateHelper::is_expired($this->expiryDate());
    }
}
