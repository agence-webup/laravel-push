<?php

namespace Webup\LaravelPush\Repositories;

use Webup\LaravelPush\Entities\Push;
use Illuminate\Support\Collection;

class PushRepository
{
    /**
     * HTTP Client
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new \GuzzleHttp\Client(['base_uri' => config('services.push_api.base_uri')]);
    }

    public function add(Push $pushToken)
    {
        $response = $this->httpClient->request('POST', 'tokens', [
            'json' => $pushToken,
        ]);
    }

    public function remove(Push $pushToken)
    {
        $response = $this->httpClient->request('DELETE', 'tokens/'.$pushToken->platform.'/'.$pushToken->token);
    }

    public function send(string $uuid, string $message, array $data = null)
    {
        $this->broadcast(collect([$uuid]), $message, $data);
    }

    public function broadcast(Collection $uuids, string $message, array $data = null)
    {
        $json = [
            'uuids' => $uuids,
            'text' => $message,
            'title' => config('services.push_api.app_name'),
        ];
        if ($data) {
            $json['custom'] = $data;
        }

        $response = $this->httpClient->request('POST', 'send', [
            'json' => $json,
        ]);
    }
}
