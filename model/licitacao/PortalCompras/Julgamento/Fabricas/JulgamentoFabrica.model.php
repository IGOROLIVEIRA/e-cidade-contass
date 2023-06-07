<?php

require_once("model/licitacao/PortalCompras/Julgamento/Julgamento.model.php");

class JulgamentoFabrica
{
    /**
     * cria Julgamento
     *
     * @param array $dados
     * @return Julgamento
     */
    public function criar(array $dados):Julgamento
    {
        $julgamento = new Julgamento();

        $julgamento->setIdJulgamento((int)$dados['_id']);

        $julgamento->setDataProposta($dados['dataInicioPropostas']);

        return $julgamento;

    }
}