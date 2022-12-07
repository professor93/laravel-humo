<?php

namespace Uzbek\LaravelHumo\Dtos\Middle\Response;

class AccountRecord
{
    public function __construct(
        public $institutionId,
        public $accountId,
        public $bankAccountId,
        public $currency,
        public $cardholderId,
        public $effectiveDate,
        public $updateDate,
        public $accountType,
        public $amountSetTime,
        public $initialAmount,
        public $bonusAmount,
        public $bonusAmountExpiry,
        public $creditLimit,
        public $creditLimitExpiry,
        public $lockedBackofficeAmount,
        public $lockTime,
        public $lockedAmount,
        public $shadowAmount,
        public $commissionGroup,
        public $timestamp,
        public $priority,
        public $status,
        public $additionalInfo,
        public $availableAmount,
        public $exponent,
    )
    {
    }
}
