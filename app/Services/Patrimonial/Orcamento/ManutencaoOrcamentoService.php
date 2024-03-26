<?php

namespace App\Services\Patrimonial\Orcamento;

use App\Services\Patrimonial\Orcamento\PcOrcamService;
use App\Services\Patrimonial\Orcamento\PcOrcamValService;
use Illuminate\Database\Capsule\Manager as DB;
use Exception;
use DBString;

class ManutencaoOrcamentoService
{
    /**
     *
     * @param array $orcamento - dados do orçamento
     * @param array $itens - itens do orçamento
     * @return void
     */
    public function save($orcamento,$itens)
    {

        try {

        DB::beginTransaction();

        $pcOrcamService = new PcOrcamService();
        $pcOrcamService->updateOrcamento($orcamento);

        $pcOrcamValService = new PcOrcamValService();
        foreach ($itens as $oItem) {
            $dados = json_decode(json_encode($oItem), true);
            $dados = DBString::utf8_decode_all($dados);
            $pcOrcamValService->updateOrcamVal($dados);
        }

        DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

}
