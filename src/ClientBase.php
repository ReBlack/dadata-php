<?php

namespace Dadata;

use GuzzleHttp as HTTP;

abstract class ClientBase
{
    public $client;

    /**
     * ClientBase constructor.
     * @param $baseUrl
     * @param $token
     * @param null $secret
     * @param bool $isKeepAlieve
     */
    public function __construct($baseUrl, $token, $secret = null, $isKeepAlive = false)
    {
        $headers = [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => "Token " . $token,
        ];

        if ($secret) {
            $headers["X-Secret"] = $secret;
        }

        $options = [
            "base_uri" => $baseUrl,
            "headers" => $headers,
            "timeout" => Settings::TIMEOUT_SEC,
        ];

        if ($isKeepAlive) {
            $options['stream'] = true;
        }


        $this->client = new HTTP\Client($options);
    }

    /**
     * @param $url
     * @param array $query
     * @return array
     */
    protected function get($url, $query = [])
    {
        $response = $this->client->get($url, ["query" => $query]);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param $url
     * @param $data
     * @return array
     */
    protected function post($url, $data)
    {
        $response = $this->client->post($url, [
            "json" => $data
        ]);
        return json_decode($response->getBody(), true);
    }
}
