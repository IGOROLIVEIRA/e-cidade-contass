<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

interface EnviadorInterface
{
    public function enviar(Licitacao $licitacao): array;
}