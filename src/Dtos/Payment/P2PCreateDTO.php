<?php

namespace Uzbek\LaravelHumo\Dtos\Payment;

class P2PCreateDTO extends BaseDTO
{
    final const SWITCHING_COBADGE = 77;
    final const SWITCHING_INNER = 48;
    final const SWITCHING_EXTERNAL = 50;

    public function __construct(
        public string      $pan,
        public string      $expiry,
        public string      $pan2,
        public int         $amount,
        public string|null $merchant_id,
        public string|null $terminal_id,
        public bool|null   $isMKB = false,
        public bool|null   $isCobadge = false,
    )
    {
    }

    public function getSwitchId(): int
    {
        return $this->isCobadge ? self::SWITCHING_COBADGE : ($this->isMKB ? self::SWITCHING_INNER : self::SWITCHING_EXTERNAL);
    }
}
