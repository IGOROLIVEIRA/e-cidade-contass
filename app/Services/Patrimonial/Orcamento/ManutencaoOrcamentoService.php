<?php

namespace App\Services\Patrimonial\Orcamento;

use App\Services\Patrimonial\Orcamento\PcOrcamService;
use App\Services\Patrimonial\Orcamento\PcOrcamValService;
use Illuminate\Database\Capsule\Manager as DB;
use cl_pcorcamval;
use db_utils;
use Exception;

class ManutencaoOrcamentoService
{

    public function save($orcamento,$itens){

        try {

        DB::beginTransaction();

        $pcOrcamService = new PcOrcamService();
        $pcOrcamService->updateOrcamento($orcamento);

        $pcOrcamValService = new PcOrcamValService();
        foreach ($itens as $oItem) {
            $dados = json_decode(json_encode($oItem), true);
            $pcOrcamValService->updateOrcamVal($dados);
        }

        DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    public function getDados($sequencial,$origemOrcamento){

        $pcOrcamService = new PcOrcamService();

        $situacao = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->situacao;

        if ($situacao != '0') {
            throw new Exception('Carregamento de dados abortado, o orçamento selecionado possui Processo Licitatório vinculado que não está com o status Em andamento.');
        }

        $precoreferencia = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->precoreferencia;

        if ($precoreferencia != null) {
            throw new Exception('Carregamento de dados abortado, o orçamento selecionado possui Preço de Referência');
        }

        $oRetorno->criterioadjudicacao = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->criterioadjudicacao;
        $oRetorno->codigoorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->codigoorcamento;
        $oRetorno->dataorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->dataorcamento;
        $oRetorno->horadoorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->horadoorcamento;
        $oRetorno->prazoentrega = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->prazoentrega;
        $oRetorno->validade = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->validade;
        $oRetorno->cotacaoprevia = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->cotacaoprevia;
        $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->obs);
        $oRetorno->itens = db_utils::getCollectionByRecord($rsInformacoesOrcamento);

    }

}
