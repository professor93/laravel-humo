<?php
/**
 * Date: 10/3/2022
 * Time: 3:55 PM
 */

namespace Uzbek\LaravelHumo\Response\Card;

use Uzbek\LaravelHumo\Response\BaseResponse;

/**
 * Class MobileAgreement
 *
 * @property-read string $description
 * @property-read string $state
 * @property-read string $phone
 */
class MobileAgreement extends BaseResponse
{
    public const STATUS_ON = 'on';

    public const STATUS_OFF = 'off';

    public const STATUS_OFF_PHONE = 'off-phone';

    public const STATUS_NO_PHONE = 'no-phone';

    public const STATUS_OFF_CARD = 'off-card';

    public const STATUS_NO_CUSTOMER = 'no-customer';

    public function isActive(): bool
    {
        return $this->state === self::STATUS_ON;
    }

    public function phone(): ?string
    {
        return $this->phone && str_starts_with($this->phone, '+')
            ? substr($this->phone, 1)
            : $this->phone;
    }

    public function status(): string
    {
        return self::getStatusList()[$this->state] ?? 'Unknown status';
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_ON => 'on',
            self::STATUS_OFF => 'off',
            self::STATUS_OFF_PHONE => 'off-phone',
            self::STATUS_NO_PHONE => 'no-phone',
            self::STATUS_OFF_CARD => 'off-card',
            self::STATUS_NO_CUSTOMER => 'no-customer',
        ];
    }
}
