<?php
/**
 * Date: 8/19/2022
 * Time: 11:16 AM
 */

namespace Uzbek\LaravelHumo\Services\Payment;

use Uzbek\LaravelHumo\Dtos\Payment\{CreditDTO, PaymentHoldDTO};
use Uzbek\LaravelHumo\Exceptions\{HumoException};
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Uzbek\LaravelHumo\Services\BaseService;
use Uzbek\LaravelHumo\Services\Payment\Responses\{Cancel, Confirm, Credit, Hold, PaymentReturn, Reco\RecoConfirm, Reco\RecoCreate, Status};
use Uzbek\LaravelHumo\Traits\PluckDetails;

class PaymentService extends BaseService
{
    use PluckDetails;

    public function __construct(PendingRequest $client, private readonly Factory $viewFactory, private readonly Repository $configRepository)
    {
        parent::__construct($client);
    }

    public function hold(PaymentHoldDTO $hold): Hold
    {
        $xml = $this->viewFactory->make('humo::payment.hold', ['hold' => $hold])->renderMin();
        $resp = $this->sendXmlRequest('payment.create', $xml)['Body']['PaymentResponse'] ?? [];
        return Hold::from($this->pluckDetails($resp));
    }

    public function confirm(string|null $payment_id = null, string|null $payment_ref = null): Confirm
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = $this->viewFactory->make('humo::payment.confirm', ['payment_id' => $payment_id, 'payment_ref' => $payment_ref])->renderMin();
        $resp = $this->sendXmlRequest('payment.confirm', $xml)['Body']['PaymentResponse'] ?? [];
        return Confirm::from($this->pluckDetails($resp));
    }

    public function confirmChangedAmount(int $amount, string|null $payment_id = null, string|null $payment_ref = null): Confirm
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = $this->viewFactory->make('humo::payment.confirm_amount_changed', ['amount' => $amount, 'payment_id' => $payment_id, 'payment_ref' => $payment_ref])->renderMin();
        $resp = $this->sendXmlRequest('payment.confirm', $xml)['Body']['PaymentResponse'] ?? [];
        return Confirm::from($this->pluckDetails($resp));
    }

    public function cancel(string $session_id, string|null $payment_id = null, string|null $payment_ref = null): Cancel
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = $this->viewFactory->make('humo::payment.cancel', ['session_id' => $session_id, 'payment_id' => $payment_id, 'payment_ref' => $payment_ref])->renderMin();
        $resp = $this->sendXmlRequest('payment.cancel', $xml)['Body'] ?? [];
        return Cancel::from($resp);
    }

    public function return(): PaymentReturn
    {
        return $this->cancelFinished(...func_get_args());
    }

    public function cancelFinished(string $payment_id, string $merchant_id, string $terminal_id): PaymentReturn
    {
        $xml = $this->viewFactory->make('humo::payment.return', ['payment_id' => $payment_id, 'merchant_id' => $merchant_id, 'terminal_id' => $terminal_id])->renderMin();
        $resp = $this->sendXmlRequest('payment.return', $xml)['Body'] ?? [];
        return PaymentReturn::from($resp);
    }

    /*
     * Doesn't need to confirm this action. It will be confirmed automatically.
     * Don't confirm it!!!
     * If you confirm it, it will be duplicated, will credit twice.
     */
    public function credit(CreditDTO $credit): Credit
    {
        $credit->checkPassportlessLimit($this->configRepository->get('humo.max_amount_without_passport'));

        $xml = $this->viewFactory->make('humo::payment.credit', ['credit' => $credit])->renderMin();
        $resp = $this->sendXmlRequest('payment.credit', $xml)['Body']['PaymentResponse'] ?? [];
        return Credit::from($this->pluckDetails($resp));
    }

    public function recoCreate(string $terminal_id, string $payment_ref): RecoCreate
    {
        $xml = $this->viewFactory->make('humo::payment.reco_create', ['payment_ref' => $payment_ref, 'terminal_id' => $terminal_id])->renderMin();
        $resp = $this->sendXmlRequest('reco.create', $xml)['Body']['PaymentResponse'] ?? [];
        return RecoCreate::from($this->pluckDetails($resp));
    }

    public function recoConfirm(string|null $payment_id = null, string|null $payment_ref = null): RecoConfirm
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = $this->viewFactory->make('humo::payment.reco_confirm', ['payment_id' => $payment_id])->renderMin();
        $resp = $this->sendXmlRequest('reco.confirm', $xml)['Body']['PaymentResponse'] ?? [];
        return RecoConfirm::from($this->pluckDetails($resp));
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
