<?php

namespace Uzbek\LaravelHumo\Services\Middle\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Account extends Data
{
    public function __construct(
        public string          $institutionId,
        public string          $accountId,
        public string          $bankAccountId,
        public string          $currency,
        public string          $cardholderId,
        public string          $accountType,
        public float           $lockedBackofficeAmount,
        public string          $lockTime,
        public float           $shadowAmount,
        public string          $priority,
        public string          $status,
        public float           $availableAmount,

        public string|Optional $effectiveDate,
        public string|Optional $updateDate,
        public float|Optional  $initialAmount,
        public string|Optional $commissionGroup,
    )
    {
    }
}

