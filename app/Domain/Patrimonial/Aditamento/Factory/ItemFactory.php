<?php

namespace App\Domain\Patrimonial\Aditamento\Factory;

use App\Domain\Patrimonial\Aditamento\Item;
use App\Models\AcordoItem;
use Illuminate\Database\Eloquent\Collection;

class ItemFactory
{
    /**
     *
     * @param AcordoItem $itemAcordo
     * @return Item
     */
    public function createByEloquentModel(AcordoItem $itemAcordo): Item
    {
        $item = new Item();
        $item->setItemSequencial((int) $itemAcordo->ac20_sequencial)
            ->setCodigoPcMater((int) $itemAcordo->ac20_pcmater)
            ->setQuantidade((float) $itemAcordo->ac20_quantidade)
            ->setValorUnitario((float) $itemAcordo->ac20_valorunitario)
            ->setValorTotal((float) $itemAcordo->ac20_valortotal)
            ->setTipoControle((bool) $itemAcordo->ac20_tipoControle)
            ->setAcordoPosicaoTipo($itemAcordo->ac20_acordoposicaotipo)
            ->setServicoQuantidade($itemAcordo->ac20_servicoquantidade);
            return $item;
    }

    /**
     *
     * @param Collection $collection
     * @return array
     */
    public function createListByCollection(Collection $collection): array
    {
        $listaItens = [];

        /** @var AcordoItem $item */
        foreach ($collection as $item) {
            $listaItens[] = $this->createByEloquentModel($item);
        }

        return $listaItens;
    }
}
