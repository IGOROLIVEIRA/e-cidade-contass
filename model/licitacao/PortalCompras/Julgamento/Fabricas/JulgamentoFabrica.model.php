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

        $julgamento->setId((int)$dados['_id']);

        $julgamento->setNumero($dados['NUMERO']);

        $julgamento->setDataProposta($dados['dataInicioPropostas']);

        $julgamento->setHoraProposta($dados['horaInicioPropostas']);

        return $julgamento;

    }
}