<?php

namespace Uzbek\LaravelHumo\Dtos\Middle\Response;

class CardRecord
{
    public function __construct(
        public $institutionId,
        public $primaryAccountNumber,
        public $effectiveDate,
        public $updateDate,
        public $prefixNumber,
        public $expiry,
        public $expiry2,
        public $cardSequenceNumber,
        public $cardSequenceNumber2,
        public $cardholderId,
        public $nameOnCard,
        public $cardholderPassword,
        public $cardholderMessage,
        public $accountRestrictionsFlag,
        public $commissionGroup,
        public $cardUserId,
        public $additionalInfo,
        public $riskGroup,
        public $riskGroup2,
        public $bankC,
        public $pinTryCount,
        public $statuses,
    )
    {
    }
}
