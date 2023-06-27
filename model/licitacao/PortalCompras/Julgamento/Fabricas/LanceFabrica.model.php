<?php

require_once("model/licitacao/PortalCompras/Julgamento/Lance.model.php");

class LanceFabrica
{
    /**
     * Cria um lance
     *
     * @param array $dados
     * @return Lance
     */
    public function criar(array $dados): Lance
    {
        $lance = new Lance();

        $lance->setIdFornecedor($dados['IdFornecedor']);
        $lance->setValorUnitario($dados['ValorUnitario']);
        $lance->setValorTotal($dados['ValorTotal']);

        return $lance;
    }

    /**
     * Cria uma lista de lances com IdFornecedor como chave
     *
     * @param array $lances
     * @return array
     */
    public function criarLista(array $lances): array
    {
        $lancesLista = [];

        foreach ($lances as $lance) {
            $lancesLista[$lance['IdFornecedor']] = $this->criar($lance);
        }

        return $lancesLista;
    }
}