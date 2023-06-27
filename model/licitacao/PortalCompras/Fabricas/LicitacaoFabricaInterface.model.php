<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

interface LicitacaoFabricaInterface
{
    public function criar($dados, int $numlinhas): Licitacao;
}
