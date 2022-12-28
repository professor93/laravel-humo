<?php
/**
 * Date: 9/30/2022
 * Time: 5:32 PM
 */

namespace Uzbek\LaravelHumo\Services\Issuing;

use Uzbek\LaravelHumo\Services\BaseService;
use Uzbek\LaravelHumo\Services\Issuing\Responses\AddCardToStop;
use Uzbek\LaravelHumo\Services\Issuing\Responses\RemoveCardFromStop;
use Uzbek\LaravelHumo\Services\Issuing\Responses\ResetPinCounter;

class Issuing extends BaseService
{
    public function addCardToStop(string $card, string $reason = 'user block'): AddCardToStop
    {
        $bank_c = substr($card, 4, 2);
        $session_id = $this->getSessionID();

        $xml = view('humo::issuing.add-card-to-stop', ['session_id' => $session_id, 'card' => $card, 'reason' => $reason, 'bank_c' => $bank_c])->renderMin();

        return new AddCardToStop($this->sendXmlRequest('8443', $xml));
    }

    public function removeCardFromStop(string $card, string $reason = 'User unblock'): RemoveCardFromStop
    {
        $bank_c = substr($card, 4, 2);
        $session_id = $this->getSessionID();

        $xml = view('humo::issuing.remove-card-from-stop', ['session_id' => $session_id, 'card' => $card, 'reason' => $reason, 'bank_c' => $bank_c])->renderMin();

        return new RemoveCardFromStop($this->sendXmlRequest('8443', $xml));
    }

    public function resetPINCounter(string $card, string $expire, string $reason = 'RESET BY OWNER'): ResetPinCounter
    {
        $bank_c = substr($card, 4, 2);
        $session_id = $this->getSessionID();

        $xml = view('humo::issuing.reset-pin-counter', ['session_id' => $session_id, 'card' => $card, 'expire' => $expire, 'reason' => $reason, 'bank_c' => $bank_c])->renderMin();

        return new ResetPinCounter($this->sendXmlRequest('8443', $xml));
    }
}
