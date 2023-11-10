<?php

class BuscaJulgamento
{
    private array $envs;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->envs = parse_ini_file('legacy_config/apipcp/.env', true);
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
        try {

            $url = $this->envs['URL']."/comprador/$publicKey/processo/$codigo?idExterno=true";
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', $url,[]);

            $resultado = json_decode($res->getBody()->__toString(),true);

            return [
                'success' => true,
                'message' => $resultado,
            ];

        } catch(GuzzleHttp\Exception\ClientException $e) {
            $resultado = json_decode($e->getResponse()->getBody()->getContents(),true);
            return [
                'success' => false,
                'message' => "Erro: ". $resultado['mensagem'],
            ];
        }

    }
}
