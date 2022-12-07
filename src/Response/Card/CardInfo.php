<?php
/**
 * Date: 10/3/2022
 * Time: 3:52 PM
 */

namespace Uzbek\LaravelHumo\Response\Card;

use Uzbek\LaravelHumo\DateHelper;
use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class CardInfo
 *
 * @property-read string $pan
 * @property-read string $expiry
 * @property-read string $nameOnCard
 * @property-read string $cardholderId
 * @property-read array $statuses
 * @property-read string $pinTryCount
 * @property-read string $mainStatus
 */
class CardInfo extends BaseResponse
{
    public const STATUS_APPROVED = '000';

    public const STATUS_RESTRICTED_CARD = '104';

    public const STATUS_CARD_NOT_AFFECTIVE = '125';

    public const STATUS_PICK_UP_RESTRICTED_CARD = '204';

    public const STATUS_SPECIAL_CONDITION = '207';

    public const STATUS_LOST_CARD = '208';

    public const STATUS_STOLEN_CARD = '209';

    public const STATUS_CARD_IS_NOT_ACTIVE_AT_BANK = '280';

    public const STATUS_CARD_IS_NOT_ACTIVE_AT_CARDHOLDER = '281';

    public function ownerName(): ?string
    {
        return $this->nameOnCard;
    }

    public function isActive(): bool
    {
        return isset($this->statuses['actionCode'])
            && $this->isStatusActive()
            && $this->isNotPinExceeded()
            && ! $this->isExpiredCard();
    }

    public function isStatusActive(): bool
    {
        return $this->statuses['actionCode'] === '000';
    }

    public function isNotPinExceeded(): bool
    {
        return $this->pinTryCount < 3;
    }

    public function status(): string
    {
        if ($this->pinTryCount >= 3) {
            return '{service} pin try count exceeded';
        }

        if (! isset($this->statuses['actionCode'])) {
            return '{service} unknown status';
        }

        if ($this->isExpiredCard()) {
            return 'Card expired';
        }

        return self::getErrorsList()[$this->statuses['actionCode']] ?? '{service} unknown status';
    }

    public static function getErrorsList(): array
    {
        return [
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_RESTRICTED_CARD => 'Decline, restricted card',
            self::STATUS_CARD_NOT_AFFECTIVE => 'Decline, card not effective',
            self::STATUS_PICK_UP_RESTRICTED_CARD => 'Pick-up, restricted card',
            self::STATUS_SPECIAL_CONDITION => 'Pick-up, special conditions',
            self::STATUS_LOST_CARD => 'Pick-up, lost card',
            self::STATUS_STOLEN_CARD => 'Pick-up, stolen card',
            self::STATUS_CARD_IS_NOT_ACTIVE_AT_BANK => 'Decline, Card is not active at Bank will',
            self::STATUS_CARD_IS_NOT_ACTIVE_AT_CARDHOLDER => 'Decline, Card is not active at Cardholder will',
        ];
    }

    public function isExpiredCard(): bool
    {
        try {
            return DateHelper::is_expired(DateHelper::expiry_date_from_string('ym', $this->expiry));
        } catch (\Throwable $exception) {
            return true;
        }
    }
}
