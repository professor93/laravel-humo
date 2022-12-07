<?php
/**
 * Date: 9/30/2022
 * Time: 6:01 PM
 */

namespace Uzbek\LaravelHumo\Response\Issuing;

use DateTime;
use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class TransactionHistory
 *
 * @property string CTIME
 * @property string CLIENT
 * @property string ACCNT_CCY
 * @property string TR_CODE2
 * @property string CCY_EXP
 * @property string REC_DATE
 * @property string POINT_CODE
 * @property string TRAN_TYPE
 * @property string ABVR_NAME
 * @property string TRAN_DATE_TIME
 * @property string STAN
 * @property string GROUPC
 * @property string ADD_INFO
 * @property string CARD
 * @property string COUNTERPARTY
 * @property string ACQREF_NR
 * @property string COUNTRY
 * @property string POST_DATE
 * @property string TR_FEE
 * @property string CARD_ACCT
 * @property string APR_CODE
 * @property string BANK_C
 * @property string TRAN_AMT
 * @property string AMOUNT_NET
 * @property string MCC_CODE
 * @property string TR_FEE2
 * @property string CITY
 * @property string CL_ACCT_KEY
 * @property string INTERNAL_NO
 * @property string FLD_104
 * @property string TRAN_CCY
 * @property string TERM_ID
 * @property string APR_SCR
 * @property string DEAL_DESC
 * @property string ACCOUNT_NO
 * @property string EXP_DATE
 * @property string MERCHANT
 * @property string TR_CODE
 * @property string LOCKING_FLAG
 */
class TransactionHistory extends BaseResponse
{
    public function __get($name)
    {
        $val = parent::__get($name);

        if (is_array($val)) {
            return $val[0] ?? null;
        }

        return $val;
    }

    public function transactionDateTime(): DateTime
    {
        return new DateTime($this->TRAN_DATE_TIME);
    }

    public function isCredit(): bool
    {
        $types = [
            '312' => 'C',
            '206' => 'C',
            '113' => 'C',
            '516' => 'C',
            '207' => 'D',
            '114' => 'C',
            '314' => 'C',
            '208' => 'C',
            '115' => 'C',
            '31G' => 'C',
            '209' => 'D',
            '120' => 'D',
            '324' => 'D',
            '224' => 'C',
            '124' => 'D',
            '325' => 'D',
            '225' => 'C',
            '125' => 'D',
            '326' => 'D',
            '226' => 'D',
            '129' => 'D',
            '327' => 'D',
            '227' => 'C',
            '204' => 'D',
            '328' => 'D',
            '228' => 'D',
            '205' => 'D',
            '32A' => 'D',
            '229' => 'C',
            '110' => 'C',
            '32j' => 'D',
            '31B' => 'C',
            '223' => 'C',
            '128' => 'D',
            '610' => 'C',
            '22k' => 'C',
            '32k' => 'D',
            '31D' => 'C',
            '11M' => 'C',
            '12D' => 'D',
            '620' => 'D',
            '11C' => 'C',
            '31l' => 'C',
            '31R' => 'C',
            '12M' => 'D',
            '12E' => 'D',
            '32a' => 'D',
            '12S' => 'D',
            '32l' => 'D',
            '31a' => 'C',
            '613' => 'C',
            '12F' => 'D',
            '32b' => 'D',
            '32P' => 'D',
            '51P' => 'C',
            '31b' => 'C',
            '614' => 'C',
            '11E' => 'C',
            '32c' => 'D',
            '52M' => 'D',
            '32g' => 'D',
            '31c' => 'C',
            '12P' => 'D',
            '11F' => 'C',
            '111' => 'C',
            '32F' => 'D',
            '31g' => 'C',
            '11L' => 'C',
            '32i' => 'D',
            '123' => 'D',
            '112' => 'C',
            '11Z' => 'C',
            '315' => 'C',
            '11N' => 'C',
            '32u' => 'D',
            '32X' => 'D',
            '11D' => 'C',
            '600' => 'D',
            '316' => 'C',
            '32v' => 'D',
            '32d' => 'D',
            '32Y' => 'D',
            '121' => 'D',
            '31W' => 'C',
            '31A' => 'C',
            '32w' => 'D',
            '32e' => 'D',
            '203' => 'D',
            '122' => 'D',
            '31f' => 'C',
            '32C' => 'D',
            '32D' => 'D',
            '32E' => 'D',
            '32G' => 'D',
            '32H' => 'D',
            '32r' => 'D',
            '32I' => 'D',
            '32K' => 'D',
            '32R' => 'D',
            '32S' => 'D',
            '32T' => 'D',
            '32y' => 'D',
            '32U' => 'D',
            '42F' => 'D',
            '42G' => 'D',
            '517' => 'C',
            '518' => 'C',
            '31U' => 'C',
            '52S' => 'D',
            '52T' => 'D',
            '52U' => 'D',
            '322' => 'D',
            '323' => 'D',
            '31H' => 'C',
            '12V' => 'D',
            '32Q' => 'D',
            '32J' => 'D',
            '31E' => 'C',
            '31K' => 'C',
            '32t' => 'D',
            '11T' => 'C',
            '32B' => 'D',
            '31J' => 'C',
            '11W' => 'C',
            '12W' => 'D',
            '11d' => 'C',
            '51F' => 'C',
            '519' => 'C',
            '52F' => 'D',
            '11V' => 'C',
            '12T' => 'D',
            '511' => 'C',
            '12C' => 'D',
            '32M' => 'D',
            '31M' => 'C',
            '32N' => 'D',
            '31N' => 'C',
            '32O' => 'D',
            '32z' => 'D',
            '130' => 'C',
            '32L' => 'D',
            '425' => 'D',
            '426' => 'C',
            '12B' => 'D',
            '52a' => 'D',
            '11A' => 'C',
            '12A' => 'D',
            '11X' => 'C',
            '12Z' => 'D',
            '12X' => 'D',
            '11G' => 'C',
            '12G' => 'D',
            '32W' => 'D',
            '329' => 'D',
            '319' => 'C',
            '32f' => 'D',
            '32n' => 'D',
            '32p' => 'D',
            '32q' => 'D',
            '32h' => 'D',
            '32s' => 'D',
            '32x' => 'D',
            '32Z' => 'D',
            '31S' => 'C',
            '31T' => 'C',
            '317' => 'C',
            '318' => 'C',
            '313' => 'C',
            '31I' => 'C',
            '525' => 'D',
            '31t' => 'C',
            '11a' => 'C',
            '11b' => 'C',
            '11c' => 'C',
            '11e' => 'C',
            '11f' => 'C',
            '12a' => 'D',
            '12b' => 'D',
            '12c' => 'D',
            '12g' => 'D',
            '12d' => 'D',
            '12f' => 'D',
            '11h' => 'C',
            '12e' => 'D',
            '12h' => 'D',
            '12i' => 'D',
            '12j' => 'D',
            '320' => 'D',
            '32o' => 'D',
            '20a' => 'D',
            '22a' => 'C',
            '20b' => 'D',
            '22b' => 'C',
            '20d' => 'D',
            '22d' => 'C',
            '20e' => 'D',
            '22e' => 'C',
            '20f' => 'D',
            '22f' => 'C',
            '11O' => 'C',
            '12O' => 'D',
            '11R' => 'C',
            '12R' => 'D',
            '31n' => 'C',
            '11P' => 'C',
            '31X' => 'C',
            '31Y' => 'C',
            '31j' => 'C',
            '31k' => 'C',
            '20k' => 'D',
        ];

        return $types[$this->TRAN_TYPE] === 'C';
    }
}
