<?php

require_once("classes/db_liclicitaimportarjulgamento_classe.php");
require_once("model/licitacao/PortalCompras/Julgamento/Proposta.model.php");
//require_once("model/licitacao/PortalCompras/Julgamento/Item.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Ranking.model.php");

class ValidaFornecedores
{
    /**
     * Verifica se existe há fornecedores não cadastrados
     *
     * @param array $ranking
     * @return void
     * @throws Exception
     */
    public function execute(Julgamento $julgamento): void
    {
        $fornecedores = [];
        $mensagem = "Fornecedores não localizados: ";
        $lotes = $julgamento->getLotes();
        $itens = array_map(fn(Lote $lote) => $lote->getItems(), $lotes);
        $rankings = array_map(fn(Item $item) => $item->getRanking(), $itens);
        $cl_liclicitaimportarjulgamento =  new cl_liclicitaimportarjulgamento();

        /** @var Ranking[] $rankings */
        foreach ($rankings as $ranking) {
            $resultado = $cl_liclicitaimportarjulgamento->buscaFornecedor($ranking->getIdFornecedor());
            if (empty($resultado)) {
                $fornecedores[] = $ranking->getIdFornecedor();
                $mensagem .= " ".$ranking->getIdFornecedor();
            }
        }

        if (!empty($fornecedores)) {
            throw new Exception($mensagem);
        }
    }
}