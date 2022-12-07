<?php

namespace Uzbek\LaravelHumo\Response\Card;

/**
 * Date: 8/17/2022
 * Time: 4:29 PM
 */

use Uzbek\LaravelHumo\Exceptions\ClientException;
use Uzbek\LaravelHumo\Response\BaseResponse;

class Info extends BaseResponse
{
    public const INDEX_CARD = 0;

    public const INDEX_MOBILE = 1;

    public const STATUS_OK = 'ok';

    public const STATUS_ERROR = 'error';

    private ?CardInfo $_card = null;

    private ?MobileAgreement $_mobileAgreement = null;

    public const KEY_CARD = 'card';

    public const KEY_MOBILE_AGREEMENT = 'mb_agreement';

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
    }

    public function card(): CardInfo
    {
        if ($this->_card === null) {
            $data = $this->findByIndex(self::INDEX_CARD);
            $this->_card = new CardInfo($data[self::KEY_CARD] ?? []);
        }

        return $this->_card;
    }

    public function mobileAgreement(): MobileAgreement
    {
        if ($this->_mobileAgreement === null) {
            $this->_mobileAgreement = new MobileAgreement($this->findByIndex(self::INDEX_MOBILE)[self::KEY_MOBILE_AGREEMENT] ?? []);
        }

        return $this->_mobileAgreement;
    }

    public function isActive(): bool
    {
        return $this->card()->isActive() && $this->mobileAgreement()->isActive();
    }

    public function isCardActive(): bool
    {
        return $this->card()->isActive();
    }

    public function isSmsOn(): bool
    {
        return $this->mobileAgreement()->isActive();
    }

    public function isSmsNotOn(): bool
    {
        return ! $this->isSmsOn();
    }

    public function status(): string
    {
        if (! $this->card()->isActive()) {
            return $this->card()->status();
        }

        return $this->mobileAgreement()->status();
    }

    public function phone(): ?string
    {
        return $this->mobileAgreement()->phone();
    }

    public function ownerName(): ?string
    {
        return $this->card()->ownerName();
    }

    protected function findByIndex(int $index): array
    {
        foreach ($this->records as $record) {
            if (isset($record['index']) && (int) $record['index'] === $index) {
                return current($record['data'] ?? []) ?: [];
            }
        }

        return [];
    }

    /**
     * @param $items
     *
     * @throws ClientException
     */
    protected function load($items)
    {
        foreach ($items as $item) {
            if (! isset($item['status'], $item['index'], $item['data'])) {
                throw new ClientException('Humo not available');
            }

            $key = key($item['data']);
            $method = $this->keyToMethodName($key);
            if (method_exists($this, $method)) {
                $this->{$method}($item['data'], $item['status'] ?? 'fail');
            }
        }
    }

    protected function setCard($data, ?string $status = 'fail')
    {
        $data['mainStatus'] = $status;
        $this->_card = new CardInfo($data);
    }

    protected function setMb_agreement($data, ?string $status = 'fail')
    {
        $data['mainStatus'] = $status;
        $this->_mobileAgreement = new MobileAgreement($data);
    }

    protected function keyToMethodName(string $key): string
    {
        return ucfirst($key);
    }
}
