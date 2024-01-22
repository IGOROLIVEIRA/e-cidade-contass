<?php

require_once("classes/db_apostilamento_classe.php");
require_once("classes/db_acordoposicao_classe.php");

class UpdateApostilamentoCommand
{
    public function execute($apostilamento, $iAcordo)
    {
        $tiposalteracaoapostila = array('1'=>15,'2'=>16,'3'=>17);

        $cl_acordoposicao = new cl_acordoposicao;

        if ($apostilamento->updateNumApostilamento &&
            !$this->validaUpdateNumApostilamento(
                $cl_acordoposicao,
                $apostilamento->si03_numapostilamento,
                $iAcordo
            )) {
                throw new Exception("Não é possível atualizar para esta numeração de apostila");
        }

        $oDaoApostilamento  = new cl_apostilamento;

        $tipoalteracaoapostila = $apostilamento->si03_tipoalteracaoapostila;
        $oDaoApostilamento->si03_sequencial = $apostilamento->si03_sequencial;
        $oDaoApostilamento->si03_tipoapostila = $apostilamento->si03_tipoapostila;
        $oDaoApostilamento->si03_tipoalteracaoapostila = $tiposalteracaoapostila[$tipoalteracaoapostila];
        $oDaoApostilamento->si03_numapostilamento = $apostilamento->si03_numapostilamento;
        $oDaoApostilamento->si03_dataapostila = $apostilamento->si03_dataapostila;
        $oDaoApostilamento->si03_descrapostila = utf8_decode($apostilamento->si03_descrapostila);
        $oDaoApostilamento->si03_justificativa = utf8_decode($apostilamento->si03_justificativa);
        $oDaoApostilamento->si03_percentualreajuste = $apostilamento->si03_percentualreajuste;
        $oDaoApostilamento->si03_indicereajuste = $apostilamento->si03_indicereajuste;
        $oDaoApostilamento->si03_descricaoreajuste = $apostilamento->si03_descricaoreajuste;
        $oDaoApostilamento->si03_descricaoindice = $apostilamento->si03_descricaoindice;
        $oDaoApostilamento->si03_criterioreajuste = $apostilamento->si03_criterioreajuste;

        $oDaoApostilamento->alterar($oDaoApostilamento->si03_sequencial);

        if ($oDaoApostilamento->erro_status === 0) {
            throw new Exception($oDaoApostilamento->erro_msg);
        }

        $cl_acordoposicao->updateApositilamento($iAcordo, $apostilamento);

        if ($cl_acordoposicao->erro_status === 0) {
            throw new Exception($cl_acordoposicao->erro_msg);
        }
    }

    private function validaUpdateNumApostilamento($cl_acordoposicao, $numApostilamento, $acordo)
    {
        $sql = $cl_acordoposicao->sqlValidaUpdateNumApostilamento($acordo, $numApostilamento);
        $cl_acordoposicao->sql_record($sql);

        if ($cl_acordoposicao->erro_status === 0 || $cl_acordoposicao->numrows > 0) {
            return false;
        }

        return true;
    }
}
