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
    public function enviar(Licitacao $licitacao): array
    {
        $client = new \GuzzleHttp\Client();
        $url = $licitacao->getUrlPortalCompras('cc86f9555f1f0134dc4d4df3c45dc457');

        try{
            $response = $client->post($url, [
                    'json' => json_decode(json_encode($licitacao),true)
            ]);

            $resultado = json_decode($response->getBody()->__toString());

            return [
                'sucess' => 1,
                'message' => $resultado->message,
            ];

        } catch(GuzzleHttp\Exception\ClientException $e) {
            $message = $e->getMessage();
            $messageRaw = substr($message,strpos($message, '{'));
            $resultado = json_decode($messageRaw);

            return [
                'sucess' => 1,
                'message' => "Erro: ".$resultado->message,
            ];
        }
    }
}