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
        $path = $licitacao->getPathPortalCompras('cc86f9555f1f0134dc4d4df3c45dc457');
        $url = 'https://apipcp.wcompras.com.br'.$path;
        //echo json_encode($licitacao);
        try{
            $res = $client->post($url, [
                    'json' => json_decode(json_encode($licitacao),true)
            ]);

        } catch(GuzzleHttp\Exception\ClientException $e) {
            $message = $e->getMessage();
            var_dump($message);
        }


        //echo $res->getStatusCode();
        // "200"
        return [];
    }
}