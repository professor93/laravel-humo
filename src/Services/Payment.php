<?php
/**
 * Date: 8/19/2022
 * Time: 11:16 AM
 */

namespace Uzbek\LaravelHumo\Services;

use Uzbek\LaravelHumo\Dtos\Payment\{CreditDTO, PaymentHoldDTO};
use Uzbek\LaravelHumo\Exceptions\{HumoException};
use Uzbek\LaravelHumo\Response\Payment\{Cancel, Confirm, Credit, Hold, PaymentReturn, RecoConfirm, RecoCreate, Status};
use Uzbek\LaravelHumo\Traits\PluckDetails;

class Payment extends BaseService
{
    use PluckDetails;

    public function hold(PaymentHoldDTO $hold): Hold
    {
        $xml = view('humo::payment.hold', compact('hold'))->renderMin();
        $resp = $this->sendXmlRequest('payment.create', $xml)['Body']['PaymentResponse'] ?? [];
        return Hold::from($this->pluckDetails($resp));
    }

    public function confirm(string|null $payment_id = null, string|null $payment_ref = null): Confirm
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = view('humo::payment.confirm', compact('payment_id', 'payment_ref'))->renderMin();
        $resp = $this->sendXmlRequest('payment.confirm', $xml)['Body']['PaymentResponse'] ?? [];
        return Confirm::from($this->pluckDetails($resp));
    }

    public function confirmChangedAmount(int $amount, string|null $payment_id = null, string|null $payment_ref = null): Confirm
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = view('humo::payment.confirm_amount_changed', compact('amount', 'payment_id', 'payment_ref'))->renderMin();
        $resp = $this->sendXmlRequest('payment.confirm', $xml)['Body']['PaymentResponse'] ?? [];
        return Confirm::from($this->pluckDetails($resp));
    }

    public function cancel(string $session_id, string|null $payment_id = null, string|null $payment_ref = null): Cancel
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = view('humo::payment.cancel', compact('session_id', 'payment_id', 'payment_ref'))->renderMin();
        $resp = $this->sendXmlRequest('payment.cancel', $xml)['Body'] ?? [];
        return Cancel::from($resp);
    }

    public function return(): PaymentReturn
    {
        return $this->cancelFinished(...func_get_args());
    }

    public function cancelFinished(string $payment_id, string $merchant_id, string $terminal_id): PaymentReturn
    {
        $xml = view('humo::payment.return', compact('payment_id', 'merchant_id', 'terminal_id'))->renderMin();
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
        $credit->checkPassportlessLimit(config('humo.max_amount_without_passport'));

        $xml = view('humo::payment.credit', compact('credit'))->renderMin();
        $resp = $this->sendXmlRequest('payment.credit', $xml)['Body']['PaymentResponse'] ?? [];
        return Credit::from($this->pluckDetails($resp));
    }

    public function recoCreate(string $terminal_id, string $payment_ref): RecoCreate
    {
        $xml = view('humo::payment.reco_create', compact('payment_ref', 'terminal_id'))->renderMin();
        $resp = $this->sendXmlRequest('reco.create', $xml)['Body']['PaymentResponse'] ?? [];
        return RecoCreate::from($this->pluckDetails($resp));
    }

    public function recoConfirm(string|null $payment_id = null, string|null $payment_ref = null): RecoConfirm
    {
        $xml = view('humo::payment.reco_confirm', compact('payment_id'))->renderMin();
        $resp = $this->sendXmlRequest('reco.confirm', $xml)['Body']['PaymentResponse'] ?? [];
        return RecoConfirm::from($this->pluckDetails($resp));
    }

    public function status(string|null $payment_id = null, string|null $payment_ref = null): Status
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = view('humo::payment.status', compact('payment_id', 'payment_ref'))->renderMin();

        $resp = $this->sendXmlRequest('payment.status', $xml)['Body']['GetPaymentResponse'] ?? [];

        if (isset($resp['details'])) {
            $resp['details'] = collect($resp['details']['item'])->pluck('value', 'name')->toArray();
        }

        return Status::from($this->pluckDetails($resp));
    }
}
