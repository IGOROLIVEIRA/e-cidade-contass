<?php

require_once("model/licitacao/PortalCompras/Julgamento/Lote.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Fabricas/PropostaFabrica.model.php");

class LoteFabrica
{
    /**
     * Criar lote
     *
     * @param array $dados
     * @return Lote
     */
    public function criar(array $dados): Lote
    {
        $lote = new Lote();
        $propostaFabrica = new PropostaFabrica();
        $rankingFabrica = new RankingFabrica();

        $lote->setIdLote($dados['IdLote']);

        $propostas = $propostaFabrica->criarLista($dados['Propostas']);
        $lote->setPropostas($propostas);

        $ranking = $rankingFabrica->criarLista($dados['Ranking']);
        $lote->setRanking($ranking);

        return $lote;
    }

    /**
     * Cria Lista de lotes
     *
     * @param array $lotes
     * @return array
     */
    public function criarLista(array $lotes): array
    {
        $listaLotes = [];

        foreach($lotes as $lote) {
            $listaLotes[] = $this->criar($lote);
        }

        return $listaLotes;
    }
}