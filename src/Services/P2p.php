<?php
/**
 * Date: 8/19/2022
 * Time: 11:16 AM
 */

namespace Uzbek\LaravelHumo\Services;

use Uzbek\LaravelHumo\Dtos\Payment\{P2PCreateDTO};
use Uzbek\LaravelHumo\Response\P2P\Create;
use Uzbek\LaravelHumo\Response\P2P\Confirm;

class P2p extends BaseService
{
    /**
     * @param P2PCreateDTO $p2p
     * @return Create
     */
    public function create(P2PCreateDTO $p2p): Create
    {
        $xml = view('humo::p2p.create', compact('p2p'))->render();

        return new Create($this->sendXmlRequest('payment.p2pCreate', $xml));
    }

    /**
     * @param string $payment_id
     * @param string|null $payment_ref
     * @return Confirm
     */
    public function confirm(string $payment_id, string|null $payment_ref = null): Confirm
    {
        $xml = view('humo::p2p.confirm', compact('payment_id', 'payment_ref'))->render();

        return new Confirm($this->sendXmlRequest('payment.p2pConfirm', $xml));
    }
}
