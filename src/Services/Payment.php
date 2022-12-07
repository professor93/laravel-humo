<?php
/**
 * Date: 8/19/2022
 * Time: 11:16 AM
 */

namespace Uzbek\LaravelHumo\Services;

use Uzbek\LaravelHumo\Dtos\Payment\{CreditDTO, PaymentHoldDTO};
use Uzbek\LaravelHumo\Exceptions\{HumoException};
use Uzbek\LaravelHumo\Response\BaseResponse;
use Uzbek\LaravelHumo\Response\P2P\{Confirm as P2pConfirm, Create as P2pCreate};
use Uzbek\LaravelHumo\Response\Payment\{Cancel, Credit, PaymentReturn, RecoConfirm, RecoCreate};

class Payment extends BaseService
{
    public function hold(PaymentHoldDTO $hold): P2pCreate
    {
        $xml = view('humo::payment.hold', compact('hold'))->render();

        return new P2pCreate($this->sendXmlRequest('payment.create', $xml));
    }

    public function confirm(string|null $payment_id = null, string|null $payment_ref = null): P2pConfirm
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = view('humo::payment.confirm', compact('payment_id', 'payment_ref'))->render();

        return new P2pConfirm($this->sendXmlRequest('payment.confirm', $xml));
    }

    public function cancel(string $session_id, string|null $payment_id = null, string|null $payment_ref = null): Cancel
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = view('humo::payment.cancel', compact('session_id', 'payment_id', 'payment_ref'))->render();

        return new Cancel($this->sendXmlRequest('payment.cancel', $xml));
    }

    public function cancelFinished(string $payment_id, string $merchant_id, string $terminal_id): PaymentReturn
    {
        $xml = view('humo::payment.return', compact('payment_id', 'merchant_id', 'terminal_id'))->render();

        return new PaymentReturn($this->sendXmlRequest('payment.return', $xml));
    }

    public function credit(CreditDTO $credit): Credit
    {
        $credit->checkPassportlessLimit(config('humo.max_amount_without_passport'));

        $xml = view('humo::payment.credit', compact('credit'))->render();

        return new Credit($this->sendXmlRequest('payment.credit', $xml));
    }

    public function recoCreate(string $terminal_id, string $payment_ref): RecoCreate
    {
        $xml = view('humo::payment.reco_create', compact('payment_ref', 'terminal_id'))->render();

        return new RecoCreate($this->sendXmlRequest('reco.create', $xml));
    }

    public function recoConfirm(string|null $payment_id = null, string|null $payment_ref = null): RecoConfirm
    {
        $xml = view('humo::payment.reco_confirm', compact('payment_id'))->render();

        return new RecoConfirm($this->sendXmlRequest('reco.confirm', $xml));
    }

    public function status(string|null $payment_id = null, string|null $payment_ref = null): BaseResponse
    {
        throw_if(empty($payment_id . $payment_ref), new HumoException(message: 'Payment ID or Payment Ref is required'));

        $xml = view('humo::payment.status', compact('payment_id', 'payment_ref'))->render();

        return new BaseResponse($this->sendXmlRequest('payment.status', $xml));
    }
}
