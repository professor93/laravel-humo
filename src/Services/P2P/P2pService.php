<?php
/**
 * Date: 8/19/2022
 * Time: 11:16 AM
 */

namespace Uzbek\LaravelHumo\Services\P2P;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Uzbek\LaravelHumo\Dtos\Payment\P2PCreateDTO;
use Uzbek\LaravelHumo\Exceptions\HumoException;
use Uzbek\LaravelHumo\Services\BaseService;
use Uzbek\LaravelHumo\Services\P2P\Responses\{Confirm, Create, Status};
use Uzbek\LaravelHumo\Traits\PluckDetails;

class P2pService extends BaseService
{
    use PluckDetails;

    public function __construct(PendingRequest $client, private readonly Factory $viewFactory)
    {
        parent::__construct($client);
    }

    public function create(P2PCreateDTO $p2p): Create
    {
        $xml = $this->viewFactory->make('humo::p2p.create', ['p2p' => $p2p])->renderMin();
        $resp = $this->sendXmlRequest('payment.p2pCreate', $xml)['Body']['RequestResponse'] ?? [];
        return Create::from($this->pluckDetails($resp));
    }

    public function confirm(string $payment_id, string|null $payment_ref = null): Confirm
    {
        $xml = $this->viewFactory->make('humo::p2p.confirm', ['payment_id' => $payment_id, 'payment_ref' => $payment_ref])->renderMin();
        $resp = $this->sendXmlRequest('payment.p2pConfirm', $xml)['Body']['PaymentResponse'] ?? [];
        return Confirm::from($this->pluckDetails($resp));
    }

    public function status(string|null $payment_id = null, string|null $payment_ref = null): Status
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = $this->viewFactory->make('humo::payment.status', ['payment_id' => $payment_id, 'payment_ref' => $payment_ref])->renderMin();

        $resp = $this->sendXmlRequest('payment.status', $xml)['Body']['GetPaymentResponse'] ?? [];

        if (isset($resp['details'])) {
            $resp['details'] = (new Collection($resp['details']['item']))->pluck('value', 'name')->toArray();
        }

        return Status::from($this->pluckDetails($resp));
    }
}
