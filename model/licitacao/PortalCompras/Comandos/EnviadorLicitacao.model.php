<?php

require_once("model/licitacao/PortalCompras/Comandos/EnviadorInterface.model.php");
require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

class EnviadorLicitacao implements EnviadorInterface
{
    /**
     * Envia para portal de compras
     *
     * @param Licitacao $licitacao
     * @return array
     */
    public function enviar(Licitacao $licitacao, string $url): array
    {
        try{
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                    'json' => json_decode(json_encode($licitacao),true)
            ]);
            $resultado = json_decode($response->getBody()->__toString());

            return [
                'sucess' => 1,
                'message' => $resultado->message,
            ];

        } catch(GuzzleHttp\Exception\ClientException $e) {

            $resultado = json_decode($e->getResponse()->getBody()->getContents());

            return [
                'success' => 2,
                'message' => "Erro: ". $resultado->message ,
            ];
        }
    }
}