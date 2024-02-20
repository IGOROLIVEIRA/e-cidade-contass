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
    public function updateByPcmaterAndPosicao(int $pcMater, int $posicao, array $dados): bool
    {
        return DB::table('acordoitem')
            ->where('ac20_pcmater', $pcMater)
            ->where('ac20_acordoposicao', $posicao)
            ->update($dados);
    }

    /**
     *
     * @param integer $pcMater
     * @param integer $posicao
     * @return AcordoItem|null
     */
    public function getItemByPcmaterAndPosicao(int $pcMater, int $posicao): ?AcordoItem
    {
        return $this->model
            ->where('ac20_pcmater', $pcMater)
            ->where('ac20_acordoposicao', $posicao)
            ->first();
    }

    /**
     * Undocumented function
     *
     * @param Item $item
     * @param integer $sequencialAcordoPosicao
     * @return AcordoItem|null
     */
    public function saveByItemAditamento(Item $item, int $sequencialAcordoPosicao): ?AcordoItem
    {

        $acordoItem = new AcordoItem();
        $dados = [
            "ac20_sequencial" => $this->model->getNextval(),
            "ac20_acordoposicao" => $sequencialAcordoPosicao,
            "ac20_pcmater" => $item->getCodigoPcMater(),
            "ac20_elemento" => $item->getCodigoElemento(),
            "ac20_ordem" => $item->getOrdem(),
            "ac20_tipocontrole" => 1,
            "ac20_servicoquantidade" => $item->isServicoQuantidade() ? 't': 'f',
            "ac20_quantidade" => $item->getQuantidade(),
            "ac20_valorunitario" => $item->getValorUnitario(),
            "ac20_valortotal" => $item->getValorTotal(),
            "ac20_matunid" => $item->getUnidade(),
            "ac20_valoraditado" => $item->getValorAditado(),
            "ac20_quantidadeaditada" => $item->getQuantidadeAditada(),
        ];

        return $acordoItem->create($dados);
    }
}
