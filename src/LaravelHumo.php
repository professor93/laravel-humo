<?php

namespace Uzbek\LaravelHumo;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Factory;
use Uzbek\LaravelHumo\Services\{Card\CardService, Middle\MiddleService, P2P\P2pService, Payment\PaymentService};

class LaravelHumo
{
    final const CCY_CODE_UZS = '860';
    private readonly PendingRequest $xml_client;
    private MiddleService|null $_middle = null;
    private PaymentService|null $_payment = null;
    private P2pService|null $_p2p = null;

    public function __construct(private readonly Repository $configRepository, private readonly Factory $viewFactory)
    {
        $this->xml_client = Http::log()
            ->withHeaders(['SOAPAction' => '""'])
            ->withBasicAuth($this->configRepository->get('humo.username'), $this->configRepository->get('humo.password'))
            ->contentType('application/xml')
            ->accept('*/*');
    }

    public function card(): CardService
    {
        return new CardService($this->xml_client->baseUrl($this->configRepository->get('humo.base_urls.card')));
    }

    /*public function accessGateway(): AccessGateway
        {
            return new AccessGateway($this->xml_client->baseUrl(config('humo.base_urls.access_gateway')));
        }

        public function issuing(): Issuing
        {
            return new Issuing($this->xml_client->baseUrl(config('humo.base_urls.issuing')));
        }*/

    public function payment(): PaymentService
    {
        if ($this->_payment === null) {
            $this->_payment = new PaymentService($this->xml_client->baseUrl($this->configRepository->get('humo.base_urls.payment')), $this->viewFactory, $this->configRepository);
        }
        return $this->_payment;
    }

    public function p2p(): P2pService
    {
        if ($this->_p2p === null) {
            $this->_p2p = new P2pService($this->xml_client->baseUrl($this->configRepository->get('humo.base_urls.payment')), $this->viewFactory);
        }
        return $this->_p2p;
    }

    public function middle(): MiddleService
    {
        if ($this->_middle === null) {
            $this->_middle = new MiddleService(Http::log()->baseUrl($this->configRepository->get('humo.base_urls.json_info'))
                ->contentType('application/json; charset=utf-8')
                ->withToken($this->configRepository->get('humo.token')));
        }
        return $this->_middle;
    }
}
