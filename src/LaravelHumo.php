<?php

namespace Uzbek\LaravelHumo;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Uzbek\LaravelHumo\Services\{Card, Middle, Payment};

class LaravelHumo
{
    private PendingRequest $xml_client;
    private Middle|null $_middle = null;
    private Payment|null $_payment = null;


    public function __construct()
    {
        $this->xml_client = Http::withHeaders(['SOAPAction' => '""'])
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

    public function middle(): Middle
    {
        if ($this->_middle === null) {
            $this->_middle = new Middle(Http::baseUrl(config('humo.base_urls.middle'))
                ->contentType('application/json; charset=utf-8')
                ->withToken(config('humo.token')));
        }
        return $this->_middle;
    }
}
