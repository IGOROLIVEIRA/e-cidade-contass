<?php

namespace App\Services\Patrimonial\Orcamento;

use App\Repositories\Patrimonial\PcOrcamRepository;
use Exception;

class PcOrcamService
{
    private $pcOrcamRepository;

    public function __construct()
    {
        $this->pcOrcamRepository = new PcOrcamRepository();
    }

    public function updateOrcamento($orcamento){

        if($orcamento->pc20_dtate == ""){
            throw new Exception("Usuário: Campo Prazo limite para entrega do orçamento não Informado.");
        }

        if($orcamento->pc20_hrate == ""){
            throw new Exception("Usuário: Campo Hora limite para entrega do orçamento não Informado.");
        }

        $orcamento->pc20_prazoentrega = $orcamento->pc20_prazoentrega == "" ? 0 : $orcamento->pc20_prazoentrega;
        $orcamento->pc20_validadeorcamento = $orcamento->pc20_validadeorcamento == "" ? 0 : $orcamento->pc20_validadeorcamento;

        $result = $this->pcOrcamRepository->update($orcamento);
        return $result;

    }

    public function getDadosManutencaoOrcamento($sequencial,$origem){

        $dadosOrcamento = $this->pcOrcamRepository->getDadosManutencaoOrcamento($sequencial,$origem);

        if ($dadosOrcamento[0]->situacao != '0') {
            throw new Exception('Carregamento de dados abortado, o orçamento selecionado possui Processo Licitatório vinculado que não está com o status Em andamento.');
        }

        if ($dadosOrcamento[0]->precoreferencia != null) {
            throw new Exception('Carregamento de dados abortado, o orçamento selecionado possui Preço de Referência');
        }

        return $dadosOrcamento;
    }
}
