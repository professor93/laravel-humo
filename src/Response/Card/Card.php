<?php
/**
 * Date: 10/3/2022
 * Time: 3:17 PM
 */

namespace Uzbek\LaravelHumo\Response\Card;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class Card
 *
 * @property-read string institutionId
 * @property-read string primaryAccountNumber
 * @property-read string effectiveDate
 * @property-read string updateDate
 * @property-read string prefixNumber
 * @property-read string expiry
 * @property-read string cardSequenceNumber
 * @property-read string cardholderId
 * @property-read string nameOnCard
 * @property-read string accountRestrictionsFlag
 * @property-read string cardUserId
 * @property-read string additionalInfo
 * @property-read string riskGroup
 * @property-read string riskGroup2
 * @property-read array statuses
 */
class Card extends BaseResponse
{
}
