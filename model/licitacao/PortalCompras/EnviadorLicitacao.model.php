<?php

require_once("model/licitacao/PortalCompras/EnviadorInterface.model.php");
require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

class EnviadorLicitacao implements EnviadorInterface
{
    public function enviar(Licitacao $licitacao): array
    {
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', 'https://apipcp.wcompras.com.br/', [
            [
                'content-type'=> 'application/json'
            ]
        ]);
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        echo $res->getBody();
        return [];
    }
}