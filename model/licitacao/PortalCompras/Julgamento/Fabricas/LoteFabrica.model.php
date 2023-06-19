<?php

require_once("model/licitacao/PortalCompras/Julgamento/Lote.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Fabricas/PropostaFabrica.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Fabricas/ItemFabrica.model.php");

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
        $itemFabrica = new ItemFabrica();

        $lote->setId($dados['NR_LOTE']);

        $itens = $itemFabrica->criarLista($dados['itens']);
        $lote->setItems($itens);

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