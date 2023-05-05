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
        var_dump("separar por lote: $separaPorLote");
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
        $descricaoLote = null;
        $itemFabrica = new ItemFabrica();
        $indiceItemLote = 0;
        $lote = new Lote();
        $lotes = [];

        for ($i = 0; $i < $numrows; $i++) {
            $resultado = db_utils::fieldsMemory($data, $i);

            if ($resultado->descricaolote !== $descricaoLote) {
                $indiceItemLote = 0;
                $lote = new Lote();
                $lote->setNumero((int)$resultado->numerolote);
                $lote->setDescricao($resultado->descricaolote);
                $lote->setExclusivoMPE((bool)$resultado->exclusivompe);
                $lote->setcotaReservada((bool)$resultado->cotareservada);
                $lote->setJustificativa("");
                $descricaoLote = $resultado->descricaolote;
            }

            $lote->setItens(
                $itemFabrica->criarItemSimples($data,$indiceItemLote)
            );
            $indiceItemLote++;
            $lotes[] = $lote;
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
            $lote->setNumero((int)$resultado->numerolote);
            $lote->setDescricao($resultado->descricaolote);
            $lote->setExclusivoMPE((bool)$resultado->exclusivompe);
            $lote->setcotaReservada((bool)$resultado->cotareservada);
            $lote->setJustificativa("");
            $lote->setItens($itemFabrica->criarItemSimples($data,$i));
            $lotes[] = $lote;
        }
        return $lotes;
    }
}