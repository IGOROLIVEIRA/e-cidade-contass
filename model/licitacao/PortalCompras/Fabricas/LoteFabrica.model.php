<?php

require_once("model/licitacao/PortalCompras/Modalidades/Componentes/Lote.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/ItemFabrica.model.php");

class LoteFabrica
{
    /**
     * Define qual estregia que irá criar lotes
     *
     * @param resource $data
     * @param integer $numrows
     * @return Lote[]
     */
    public function criar($data, int $numrows): array
    {
        $separaPorLote = db_utils::fieldsMemory($data, 0)->separarporlotes;

        if ($separaPorLote == 'f') {
         return $this->separarPorItem($data, $numrows);
        }
        return $this->separarPorLote($data, $numrows);
    }

   /**
    * Cria lotes separado por descricao
    *
    * @param resource $data
    * @param integer $numrows
    * @return Lote[]
    */
    private function separarPorLote($data, int $numrows): array
    {
        $descricaoLote = "";
        $itemFabrica = new ItemFabrica();
        $lote = new Lote();
        $lotes = [];
        $numeroLote = 1;

        for ($i = 0; $i < $numrows; $i++) {
            $resultado = db_utils::fieldsMemory($data, $i);

            if ($resultado->descricaolote !== $descricaoLote) {
                $lote = new Lote();
                $lote->setDescricao($resultado->descricaolote);
                $lote->setExclusivoMPE($resultado->exclusivompelote);
                $lote->setcotaReservada($resultado->cotareservada);
                $lote->setJustificativa("");
                $descricaoLote = $resultado->descricaolote;
                $numeroLote++;

                $lotes[] = $lote;
            }

            $lote->setItens(
                $itemFabrica->criarItemSimples($data,$i)
            );
        }
        return $lotes;
    }

    /**
     * Cria lote separado por item
     *
     * @param resource $data
     * @param integer $numrows
     * @return Lote[]
     */
    private function separarPorItem($data, int $numrows): array
    {
        $lotes = [];
        $resultado = db_utils::fieldsMemory($data, 0);
        $itemFabrica = new ItemFabrica();

        for ($i = 0; $i < $numrows; $i++) {
            $lote = new Lote();
            $lote->setNumero($i);
            $lote->setDescricao($resultado->descricaolote);
            $lote->setExclusivoMPE($resultado->exclusivompe);
            $lote->setcotaReservada($resultado->cotareservada);
            $lote->setJustificativa("");
            $lote->setItens($itemFabrica->criarItemSimples($data, $i));
            $lotes[] = $lote;
        }
        return $lotes;
    }
}
