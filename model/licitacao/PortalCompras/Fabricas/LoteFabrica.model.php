<?php

require_once("model/licitacao/PortalCompras/Modalidades/Componentes/Lote.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/ItemFabrica.model.php");

class LoteFabrica
{
    /**
     * Undocumented function
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
    * Undocumented function
    *
    * @param resource $data
    * @param integer $numrows
    * @return Lote[]
    */
    private function separarPorLote($data, int $numrows): array
    {
        $descricaoLote = "";
        $itemFabrica = new ItemFabrica();
        $indiceItemLote = 0;
        $lote = new Lote();
        $lotes = [];
        $numeroLote = 1;

        for ($i = 0; $i < $numrows; $i++) {
            $resultado = db_utils::fieldsMemory($data, $i);

            if ($resultado->descricaolote !== $descricaoLote) {
                $indiceItemLote = 0;
                $lote = new Lote();
                $lote->setNumero($numeroLote);
                $lote->setDescricao($resultado->descricaolote);
                $lote->setExclusivoMPE((bool)$resultado->exclusivompe);
                $lote->setcotaReservada($resultado->cotareservada);
                $lote->setJustificativa("");
                $descricaoLote = $resultado->descricaolote;
                $numeroLote++;

                $lotes[] = $lote;
            }

            $lote->setItens(
                $itemFabrica->criarItemSimples($data,$indiceItemLote)
            );

            $indiceItemLote++;

        }
        return $lotes;
    }

    /**
     * Undocumented function
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
            $lote->setExclusivoMPE((bool)$resultado->exclusivompe);
            $lote->setcotaReservada($resultado->cotareservada);
            $lote->setJustificativa("");
            $lote->setItens($itemFabrica->criarItemSimples($data, $i));
            $lotes[] = $lote;
        }
        return $lotes;
    }
}