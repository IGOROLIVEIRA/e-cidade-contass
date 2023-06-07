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

    /**
     * Undocumented function
     *
     * @param integer $codigo
     * @param string $publicKey
     * @return array
     */
    public function execute(int $codigo, string $publicKey): array
    {
        $url = $this->envs['URL']."/comprador/$publicKey/processo/$codigo?idExterno=true";
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $url,[]);

        return json_decode($res->getBody()->__toString(),true);
    }
}