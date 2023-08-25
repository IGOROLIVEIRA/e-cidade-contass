<?php

require_once("classes/db_apostilamento_classe.php");
require_once("classes/db_acordoposicao_classe.php");

class UpdateApostilamentoCommand
{
    public function execute($apostilamento, $iAcordo)
    {
        $tiposalteracaoapostila = array('1'=>15,'2'=>16,'3'=>17);

        $oDaoApostilamento  = new cl_apostilamento;
        $tipoalteracaoapostila = $apostilamento->si03_tipoalteracaoapostila;
        $oDaoApostilamento->si03_sequencial = $apostilamento->si03_sequencial;
        $oDaoApostilamento->si03_tipoapostila = $apostilamento->si03_tipoapostila;
        $oDaoApostilamento->si03_tipoalteracaoapostila = $tiposalteracaoapostila[$tipoalteracaoapostila];
        $oDaoApostilamento->si03_numapostilamento = $apostilamento->si03_numapostilamento;
        $oDaoApostilamento->si03_dataapostila = $apostilamento->si03_dataapostila;
        $oDaoApostilamento->si03_descrapostila = $apostilamento->si03_descrapostila;
        $oDaoApostilamento->si03_descrapostila = $apostilamento->si03_descrapostila;
        $oDaoApostilamento->si03_percentualreajuste = $apostilamento->si03_percentualreajuste;
        $oDaoApostilamento->si03_indicereajuste = $apostilamento->si03_indicereajuste;
        
        $oDaoApostilamento->alterar($oDaoApostilamento->si03_sequencial);

        if ($oDaoApostilamento->erro_status === 0) {
            throw new Exception($oDaoApostilamento->erro_msg);
        }

        $cl_acordoposicao = new cl_acordoposicao;
        $cl_acordoposicao->updateNumeroApositilamento($iAcordo, $apostilamento->si03_numapostilamento);
    }
}
