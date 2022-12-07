<?php

namespace Uzbek\LaravelHumo;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Uzbek\LaravelHumo\Services\{AccessGateway, Card, Issuing, Middle, Payment};

class LaravelHumo
{
    private PendingRequest $xml_client;
    private ?Middle $_middle = null;
    private ?Payment $_payment = null;


    public function __construct(private readonly array $config)
    {
        $this->xml_client = Http::withHeaders(['SOAPAction' => '""'])
            ->withBasicAuth($this->config['username'], $this->config['password'])
            ->contentType('application/xml')
            ->accept('*/*');
    }

    public function card(): Card
    {
        return new Card($this->xml_client->baseUrl($this->config['base_urls']['card']));
    }

    public function accessGateway(): AccessGateway
    {
        return new AccessGateway($this->xml_client->baseUrl($this->config['base_urls']['access_gateway']));
    }

    public function issuing(): Issuing
    {
        return new Issuing($this->xml_client->baseUrl($this->config['base_urls']['issuing']));
    }

    public function payment(): Payment
    {
        if ($this->_payment === null) {
            $this->_payment = new Payment($this->xml_client->baseUrl($this->config['base_urls']['payment']));
        }
        return $this->_payment;
    }

    public function middle(): Middle
    {
        if ($this->_middle === null) {
            $this->_middle = new Middle(Http::baseUrl($this->config['base_urls']['middle'])
                ->contentType('application/json; charset=utf-8')
                ->withToken($this->config['token']));
        }
        return $this->_middle;
    }
}
