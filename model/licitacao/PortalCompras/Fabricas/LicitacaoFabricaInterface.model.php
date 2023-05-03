<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

interface LicitacaoFabricaInterface
{
    public function create($data, int $numrows): Licitacao;
}