<?php

namespace Uzbek\LaravelHumo\Services\Middle\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class TransactionHistory extends Data
{
    public function __construct(
        #[DataCollectionOf(TransactionHistoryItem::class)]
        public DataCollection|Optional $history,
        public string $pan,
        public string $date_from,
        public string $date_to,
    )
    {
    }
}
