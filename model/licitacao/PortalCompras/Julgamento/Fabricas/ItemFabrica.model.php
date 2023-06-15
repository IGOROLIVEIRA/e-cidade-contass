<?php

require_once("model/licitacao/PortalCompras/Julgamento/Item.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Comandos/ValidaTipoJulgamento.model.php");

class ItemFabrica
{
    /**
     * Cria item
     *
     * @param array $dados
     * @return Item
     */
    public function criar(array $dados): Item
    {
        $item = new Item();
        $propostaFabrica = new PropostaFabrica();
        $rankingFabrica = new RankingFabrica();


        $item->setId($dados['_id']);

        $propostas = $propostaFabrica->criarLista($dados['Propostas']);
        $item->setPropostas($propostas);

        $ranking = $rankingFabrica->criarLista($dados['Ranking']);
        $item->setRanking($ranking);

        $tipoJulgamento = (new ValidaTipoJulgamento)->execute($dados['tipoJulgamento']);
        $item->setTipoJulgamento($tipoJulgamento);

        return $item;
    }

    /**
     * Cria Lista de lotes
     *
     * @param array $lotes
     * @return array
     */
    public function criarLista(array $itens): array
    {
        $listaItens = [];

        foreach($itens as $item) {
            $listaItens[] = $this->criar($item);
        }

        return $listaItens;
    }
}