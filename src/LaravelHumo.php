<?php

namespace Uzbek\LaravelHumo;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Uzbek\LaravelHumo\Services\{Card, Middle, P2p, Payment};

class LaravelHumo
{
    const CCY_CODE_UZS = '860';
    private PendingRequest $xml_client;
    private Middle|null $_middle = null;
    private Payment|null $_payment = null;
    private P2p|null $_p2p = null;


    public function __construct()
    {
        $this->xml_client = Http::log()->withHeaders(['SOAPAction' => '""'])
            ->withBasicAuth(config('humo.username'), config('humo.password'))
            ->contentType('application/xml')
            ->accept('*/*');
    }

    public function card(): Card
    {
        return new Card($this->xml_client->baseUrl(config('humo.base_urls.card')));
    }

    /*    public function accessGateway(): AccessGateway
        {
            return new AccessGateway($this->xml_client->baseUrl(config('humo.base_urls.access_gateway')));
        }

        public function issuing(): Issuing
        {
            return new Issuing($this->xml_client->baseUrl(config('humo.base_urls.issuing')));
        }*/

    public function payment(): Payment
    {
        if ($this->_payment === null) {
            $this->_payment = new Payment($this->xml_client->baseUrl(config('humo.base_urls.payment')));
        }
        return $this->_payment;
    }

    public function p2p(): P2p
    {
        if ($this->_p2p === null) {
            $this->_p2p = new P2p($this->xml_client->baseUrl(config('humo.base_urls.payment')));
        }
        return $this->_p2p;
    }

    public function middle(): Middle
    {
        if ($this->_middle === null) {
            $this->_middle = new Middle(Http::log()->baseUrl(config('humo.base_urls.json_info'))
                ->contentType('application/json; charset=utf-8')
                ->withToken(config('humo.token')));
        }
        return $this->_middle;
    }
}
