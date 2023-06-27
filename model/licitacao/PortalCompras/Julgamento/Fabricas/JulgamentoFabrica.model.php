<?php

require_once("model/licitacao/PortalCompras/Julgamento/Julgamento.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Fabricas/LoteFabrica.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Fabricas/ParticipanteFabrica.model.php");

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
        $loteFabrica = new LoteFabrica();
        $participanteFabrica = new ParticipanteFabrica();

        $julgamento->setId((int)$dados['_id']);

        $julgamento->setNumero($dados['NUMERO']);

        $julgamento->setDataProposta($dados['dataInicioPropostas']);

        $julgamento->setHoraProposta($dados['horaInicioPropostas']);

        $julgamento->setDataAberturaProposta($dados['dataAberturaPropostas']);

        $lotes = $loteFabrica->criarLista($dados['lotes']);
        $julgamento->setLotes($lotes);

        $participantes = $participanteFabrica->criarLista($dados['Participantes']);
        $julgamento->setParticipantes($participantes);


        return $julgamento;

    }
}