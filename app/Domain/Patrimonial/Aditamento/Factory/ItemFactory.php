<?php

namespace App\Domain\Patrimonial\Aditamento\Factory;

use App\Domain\Patrimonial\Aditamento\Item;
use App\Models\AcordoItem;
use DateTime;
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
            ->setServicoQuantidade($itemAcordo->ac20_servicoquantidade)
            ->setDescricaoItem($itemAcordo->pcMater->pc01_descrmater);

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

    /**
     *
     * @param array $itensRaw
     * @param array $selecionados
     * @return array
     */
    public function createSelectedList(array $itensRaw, array $selecionados): array
    {
        $listaItens = [];

         foreach ($itensRaw as $itemRaw) {
            if (!in_array($itemRaw->codigoitem, $selecionados)) {
                continue;
            }

            $item = new Item();
            $item->setItemSequencial((int) $itemRaw->codigoitem)
                ->setQuantidade((float) $itemRaw->quantidade)
                ->setValorUnitario((float) $itemRaw->valorunitario)
                ->setValorTotal((float) $itemRaw->valortotal);

            $dataInicio = !empty($itemRaw->dtexecucaoinicio)
                ? DateTime::createFromFormat('Y-m-d',$itemRaw->dtexecucaoinicio)
                : null;

            $dataFim = !empty($itemRaw->dtexecucaofim)
                ? DateTime::createFromFormat('Y-m-d', $itemRaw->dtexecucaoinicio)
                : null;

           
            $item->setInicioExecucao($dataInicio)
                 ->setFimExecucao($dataFim);

            $listaItens[] = $item;
        }

        return $listaItens;
    }
}
