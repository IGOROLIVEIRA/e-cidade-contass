<?php

require_once("model/licitacao/PortalCompras/Julgamento/Proposta.model.php");

class PropostaFabrica
{
    /**
     * Criar Proposta
     *
     * @param array $dados
     * @return Proposta
     */
    public function criar(array $dados): Proposta
    {
        $proposta = new Proposta();

        $proposta->setIdItem($dados['IdItem']);
        $proposta->setData($dados['Data']);
        $proposta->setHoras($dados['Hora']);
        $proposta->setIdFornecedor($dados['IdFornecedor']);
        $proposta->setModelo($dados['Modelo']);
        $proposta->setMarca($dados['Marca']);
        $proposta->setFabricante($dados['Fabricante']);
        $proposta->setDetalhamento($dados['IdFornecedor']);
        $proposta->setValidadeProposta($dados['ValidadeProposta']);
        $proposta->setQuantidade($dados['Quantidade']);
        $proposta->setValorUnitario($dados['ValorUnitario']);
        $proposta->setValorTotal($dados['ValorTotal']);
        $proposta->setValido((bool)$dados['Valido']);

        return $proposta;
    }

    /**
     * Criar lista de propostas
     *
     * @param array $propostasArray
     * @return array
     */
    public function criarLista(array $propostasArray): array
    {
        $listaPropostas = [];
        foreach($propostasArray as $proposta) {
            if((bool)$proposta['Valido'] == true) {
                $listaPropostas[] = $this->criar($proposta);
            }
        }

        return $listaPropostas;
    }
}