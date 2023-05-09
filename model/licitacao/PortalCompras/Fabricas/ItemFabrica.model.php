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
        $item->setNatureza((int)$resultado->natureza);
        $item->setSiglaUnidade(utf8_encode($resultado->siglaunidade));
        $item->setValorReferencia((float)$resultado->valorreferencia);
        $item->setQuantidadeTotal((float)$resultado->quantidadetotal);
        $item->setQuantidadeCota((float)$resultado->quantidadecota);
        return $item;
    }
}