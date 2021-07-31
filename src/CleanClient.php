<?php

namespace Dadata;

class CleanClient extends ClientBase
{
    const BASE_URL = "https://cleaner.dadata.ru/api/v1/";

    public function __construct($token, $secret, $isKeepAlive = false)
    {
        parent::__construct(self::BASE_URL, $token, $secret, $isKeepAlive);
    }

    public function clean($name, $value)
    {
        $url = "clean/$name";
        $fields = array($value);
        $response = $this->post($url, $fields);

        return isset($response[0]) ? $response[0] : [];
    }

    public function cleanRecord($structure, $record)
    {
        $url = "clean";
        $data = [
            "structure" => $structure,
            "data" => [$record]
        ];
        $response = $this->post($url, $data);
        return $response["data"][0];
    }
}
