<?php

namespace App\Repositories\Patrimonial;

use App\Domain\Patrimonial\Aditamento\ItemDotacao;
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

    /**
     *
     * @param ItemDotacao $itemDotacao
     * @param integer $acordoItemSequencial
     * @return AcordoItemDotacao|null
     */
    public function saveByDomainAditamento(ItemDotacao $itemDotacao, int $acordoItemSequencial): ?AcordoItemDotacao
    {
        $data = [
            'ac22_sequencial' => $this->model->getNextval(),
            'ac22_coddot'     => $itemDotacao->getCodigoDotacao(),
            'ac22_anousu'     => $itemDotacao->getAnoDotacao(),
            'ac22_acordoitem' => $acordoItemSequencial,
            'ac22_valor'      => $itemDotacao->getValor(),
            'ac22_quantidade' => $itemDotacao->getQuantidade()
        ];

        return $this->model->create($data);
    }
}

