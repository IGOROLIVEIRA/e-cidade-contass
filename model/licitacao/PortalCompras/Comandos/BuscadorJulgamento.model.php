<?php

class BuscadorJulgamento
{
    private array $envs;
    public function __construct()
    {

    }

    public function execute(int $codigo, string $publicKey)
    {
        $url = $this->envs['URL']."/comprador/$publicKey/";
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.github.com/user', [
        'auth' => ['user', 'pass']
        ]);
    }
}