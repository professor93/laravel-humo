<?php
/**
 * Date: 8/17/2022
 * Time: 3:17 PM
 */

namespace Uzbek\LaravelHumo\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Traits\Macroable;
use Ramsey\Uuid\Uuid;

class BaseService
{
    use Macroable;

    public string|null $session_id = null;

    public function __construct(protected readonly PendingRequest $client)
    {
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
        return (string)Uuid::uuid4();
    }

    protected function sendXmlRequest($method, $body): array
    {
        /** @var array $response */
        $response = $this->client
            ->withBody($body, 'application/xml')
            ->xMethod($method)
            ->post('/')->xml();

        return $response;
    }

    //NOT READY. TODO: NOT READY NOT READY

    protected function sendJsonRequest($method, $body)//NOT READY
    {
        return $this->client
            ->withBody($body, 'application/json')
            ->xMethod($method)
//            ->withHeaders(['X-Request-Method' => $method])
            ->post('');
    }
}
