<?php

namespace Uzbek\LaravelHumo\Dtos\Middle\Response;

enum CardStatus: string
{
    case APPROVED = '000';
    case DECLINE_RESTRICTED_CARD = '104';
    case DECLINE_CARD_NOT_EFFECTIVE = '125';
    case PICK_UP_RESTRICTED_CARD = '204';
    case PICK_UP_SPECIAL_CONDITIONS = '207';
    case PICK_UP_LOST_CARD = '208';
    case PICK_UP_STOLEN_CARD = '209';
    case DECLINE_CARD_IS_NOT_ACTIVE_AT_BANK_WILL = '280';
    case DECLINE_CARD_IS_NOT_ACTIVE_AT_CARDHOLDER_WILL = '281';

    public function message(): string
    {
        return match ($this) {
            self::APPROVED => 'Approved',
            self::DECLINE_RESTRICTED_CARD => 'Decline, restricted card',
            self::DECLINE_CARD_NOT_EFFECTIVE => 'Decline, card not effective',
            self::PICK_UP_RESTRICTED_CARD => 'Pick-up, restricted card',
            self::PICK_UP_SPECIAL_CONDITIONS => 'Pick-up, special conditions',
            self::PICK_UP_LOST_CARD => 'Pick-up, lost card',
            self::PICK_UP_STOLEN_CARD => 'Pick-up, stolen card',
            self::DECLINE_CARD_IS_NOT_ACTIVE_AT_BANK_WILL => 'Decline, Card is not active at Bank will',
            self::DECLINE_CARD_IS_NOT_ACTIVE_AT_CARDHOLDER_WILL => 'Decline, Card is not active at Cardholder will',
        };
    }
}
