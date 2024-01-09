<?php

namespace App\Repositories\Patrimonial;

use App\Domain\Patrimonial\Aditamento\Item;
use App\Models\AcordoItem;
use App\Repositories\Contracts\Patrimonial\AcordoItemRepositoryInterface;
use Illuminate\Database\Capsule\Manager as DB;

class AcordoItemRepository implements AcordoItemRepositoryInterface
{
    /**
     *
     * @var AcordoItem
     */
    private AcordoItem $model;

    /**
     *
     * @var AcordoItem|null
     */
    private ?AcordoItem $ultimoItemSalvo;

    public function __construct()
    {
        $this->model = new AcordoItem();
    }

    /**
     * Undocumented function
     *
     * @param integer $pcMater
     * @param integer $posicao
     * @param array $dados
     * @return boolean
     */
    public function updateByPcmaterAndPosicao(int $pcMater,int $posicao, array $dados): bool
    {
        return DB::table('acordoitem')
        ->where('ac20_pcmater', $pcMater)
        ->where('ac20_posicao', $posicao)
        ->update($dados);
    }

    public function getItemByPcmaterAndPosicao(int $pcMater,int $posicao): ?AcordoItem
    {
        return $this->model
        ->where('ac20_pcmater', $pcMater)
        ->where('ac20_posicao', $posicao)
        ->first();
    }

    public function saveByItemAditamento(Item $item, int $sequencialAcordoPosicao): bool
    {
        $acordoItem = $this->model;
        $acordoItem->ac20_acordoposicao = $sequencialAcordoPosicao;
        $acordoItem->ac20_pcmater = $item->getCodigoPcMater();
        $acordoItem->ac20_quantidade = $item->getQuantidade();
        $acordoItem->ac20_valorunitario = $item->getValorUnitario();
        $acordoItem->ac20_valortotal = $item->getValorTotal();
        $result = $acordoItem->save();
        if ($result) {
            $this->ultimoItemSalvo = $acordoItem;
        }

        return $result;
    }

    /**
     *
     * @return AcordoItem|null
     */
    public function getUltimoItemSalvo(): ?AcordoItem
    {
        return $this->ultimoItemSalvo;
    }
}
