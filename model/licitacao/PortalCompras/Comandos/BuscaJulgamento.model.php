<?php

class BuscaJulgamento
{
    private array $envs;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->envs = parse_ini_file('config/apipcp/.env', true);
    }

    public function execute(int $codigo, string $publicKey)
    {
        $url = $this->envs['URL']."/comprador/$publicKey/processo/$codigo?idExterno=true";
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $url,[]);

        var_dump($res->getBody()->__toString());
        die();
    }
}