<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

interface EnviaLicitacaoPcpInterface
{
    public function execute(Licitacao $licitacao, string $url): array;
}
