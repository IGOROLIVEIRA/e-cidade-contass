<?php

require_once("classes/db_liclicitaimportarjulgamento_classe.php");

class ValidaFornecedores
{
    /**
     * Verifica se existe h� fornecedores n�o cadastrados
     *
     * @param array $ranking
     * @return void
     * @throws Exception
     */
    public function execute(array $ranking): void
    {
        $fornecedores = [];
        $mensagem = "Fornecedores n�o localizados: ";
        $cl_liclicitaimportarjulgamento =  new cl_liclicitaimportarjulgamento();
        foreach ($ranking as $posicao) {
            $resultado = $cl_liclicitaimportarjulgamento->buscaFornecedor($posicao['IdFornecedor']);
            if (empty($resultado)) {
                $fornecedores[] = $posicao['IdFornecedor'];
                $mensagem .= " ".$posicao['IdFornecedor'];
            }
        }

        if (!empty($fornecedores)) {
            throw new Exception($mensagem);
        }
    }
}