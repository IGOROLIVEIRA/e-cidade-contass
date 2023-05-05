<?php

require_once("model/licitacao/PortalCompras/Modalidades/Componentes/Item.model.php");

class ItemFabrica
{
    /**
     * Undocumented function
     *
     * @param resource $dados
     * @param integer $linhaAtual
     * @return Item
     */
    public function criarItemSimples($dados, int $linhaAtual): Item
    {
        $resultado = db_utils::fieldsMemory($dados, $linhaAtual);
        $item = new Item();
        $item->setNumero($linhaAtual + 1);
        $item->setNumeroInterno((int)$resultado->numerointerno);
        $item->setDescricao($resultado->descricaoitem);
        $item->setNatureza($resultado->natureza);
        $item->setSiglaUnidade($resultado->siglaunidade);
        $item->setValorReferencia($resultado->valorreferencia);
        $item->setQuantidadeTotal($resultado->quantidadetotal);
        $item->setQuantidadeCota($resultado->quantidadecota);

        return $item;
    }
}