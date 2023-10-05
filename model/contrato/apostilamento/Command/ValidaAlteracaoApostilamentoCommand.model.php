<?php

require_once("classes/db_acordoposicao_classe.php");

class ValidaAlteracaoApostilamentoCommand
{
    public function execute($iAcordo)
    {
        $cl_acordoposicao = new cl_acordoposicao;
        $sql = $cl_acordoposicao->sqlAPosicaoApostilamentoEmpenho($iAcordo);

        $cl_acordoposicao->sql_record($sql);

        if ($cl_acordoposicao->numrows != 0) {
            throw new Exception("A alteração não poderá ser efetuada, o apostilamento possui autorização(ões) e/ou empenho(s) vinculado(s).");
        }
    }
}
