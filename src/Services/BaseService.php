<?php
/**
 * Date: 8/17/2022
 * Time: 3:17 PM
 */

namespace Uzbek\LaravelHumo\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Ramsey\Uuid\Uuid;
use Uzbek\LaravelHumo\Exceptions\Exception;

class BaseService
{
    use Macroable;

    public string|null $session_id = null;
    protected mixed $config;

    public function __construct(protected readonly PendingRequest $client)
    {
        $this->config = config('humo');
    }

    public function getSessionID(): string
    {
        if ($this->session_id === null) {
            $this->session_id = $this->getNewSessionID();
        }
        return $this->session_id;
    }

    public function getNewSessionID(): string
    {
        try {
            $session_id = (string)Uuid::uuid4();
        } catch (Exception) {
            $session_id = time() . '-' . Str::random(10);
        }

        return $session_id;
    }

    public function sendOldXmlRequest(string $url_type, string $xml, string $session_id, string $method = '')
    {
        return Http::withHeaders(['Content-Type' => 'application/xml', 'Accept' => '*/*', 'SOAPAction' => '""', 'X-Request-Method' => $method])
            ->withBasicAuth($this->config['username'], $this->config['password'])
            ->post($this->getBaseUrls()[$url_type], [
                'body' => $xml])
            ->throw(function ($response, $e) {
                throw new Exception($response->getBody()->getContents(), $response->status());
            })->json();
    }

    protected function sendXmlRequest($method, $body): array
    {
        /** @var array $response */
        $response = $this->client
            ->withBody($body, 'application/xml')
            ->withHeaders(['X-Request-Method' => $method])
            ->post('/')->xml();

        return $response;
    }

    //NOT READY. TODO: NOT READY NOT READY

    protected function sendJsonRequest($method, $body)//NOT READY
    {
        return $this->client
            ->withBody($body, 'application/json')
            ->withHeaders(['X-Request-Method' => $method])
            ->post('');
    }
}
