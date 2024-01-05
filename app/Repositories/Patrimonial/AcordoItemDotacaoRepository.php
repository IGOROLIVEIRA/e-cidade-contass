<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoItemDotacao;
use App\Repositories\Contracts\Patrimonial\AcordoItemDotacaoRepositoryInterface;
use Illuminate\Database\Capsule\Manager as DB;

class AcordoItemDotacaoRepository implements AcordoItemDotacaoRepositoryInterface
{
    private AcordoItemDotacao $model;

    public function __construct()
    {
        $this->model = new AcordoItemDotacao();
    }

    public function updateByAcordoItem(int $codigoItem, array $dados): bool
    {
      $result =  DB::table('acordoitemdotacao')
            ->where('ac22_acordoitem', $codigoItem)
            ->update($dados);

        if ($result === 1)  {
            return true;
        }
        
        return false;
    }

    public function getQtdDotacaoByAcordoItem(int $acordoItem): int
    {
        $acordosItemDotacoes = $this->model->where('ac22_acordoitem', $acordoItem)->get(['ac22_sequencial']);

        if (empty($acordosItemDotacoes)) {
            return 0;
        }

        return count($acordosItemDotacoes->toArray());
    }
}

