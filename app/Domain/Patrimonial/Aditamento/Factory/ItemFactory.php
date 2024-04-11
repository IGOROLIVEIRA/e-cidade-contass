<?php

namespace App\Domain\Patrimonial\Aditamento\Factory;

use App\Domain\Patrimonial\Aditamento\Item;
use App\Models\AcordoItem;
use App\Repositories\Patrimonial\AcordoItemExecutadoRepository;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class ItemFactory
{
    /**
     *
     * @param Collection $itens
     * @param Collection $itensPosicaoAnterior
     * @return array
     */
    public function createListByCollection(Collection $itens, ?Collection $itensPosicaoAnterior = null): array
    {
        $listaItens = [];

        /** @var AcordoItem $item */
        foreach ($itens as $key => $item) {
            $itemPosicaoAnterior = !empty($itensPosicaoAnterior)
                ? $itensPosicaoAnterior[$key]
                : null;

            $listaItens[] = $this->createByEloquentModel($item, $itemPosicaoAnterior);
        }

        return $listaItens;
    }

    /**
     *
     * @param AcordoItem $itemAcordo
     * @param AcordoItem $itemPosicaoAnterior
     * @return Item
     */
    public function createByEloquentModel(AcordoItem $itemAcordo, ?AcordoItem $itemPosicaoAnterior = null): Item
    {
        $item = new Item();

        $item->setItemSequencial((int) $itemAcordo->ac20_sequencial)
            ->setCodigoPcMater((int) $itemAcordo->ac20_pcmater)
            ->setQuantidade((float) $itemAcordo->ac20_quantidade)
            ->setValorUnitario((float) $itemAcordo->ac20_valorunitario)
            ->setValorTotal((float) $itemAcordo->ac20_valortotal)
            ->setTipoControle($itemAcordo->ac20_tipocontrole == 1)
            ->setAcordoPosicaoTipo($itemAcordo->ac20_acordoposicaotipo)
            ->setServicoQuantidade($itemAcordo->ac20_servicoquantidade)
            ->setDescricaoItem($itemAcordo->pcMater->pc01_descrmater);

        $dataInicio = !empty($itemAcordo->itemPeriodo->ac41_datainicial)
            ? DateTime::createFromFormat('Y-m-d',$itemAcordo->itemPeriodo->ac41_datainicial)
            : null;

        $dataFim = !empty($itemAcordo->itemPeriodo->ac41_datafinal)
            ? DateTime::createFromFormat('Y-m-d', $itemAcordo->itemPeriodo->ac41_datafinal)
            : null;

        $item->setInicioExecucao($dataInicio)
            ->setFimExecucao($dataFim);

        if (!empty($itemPosicaoAnterior)) {
            $item->setQuantidadeAnterior((float) $itemPosicaoAnterior->ac20_quantidade)
                ->setValorAnteriorUnitario((float) $itemPosicaoAnterior->ac20_valorunitario);

            $eExecutado = (new AcordoItemExecutadoRepository())->eItemExecutado($itemPosicaoAnterior->ac20_sequencial);
            $item->setEExecutado($eExecutado);
        }

        return $item;
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

         foreach ($itensRaw as $key => $itemRaw) {
            if (!in_array($itemRaw->codigoitem, $selecionados)) {
                continue;
            }

            $item = new Item();

            $item->setItemSequencial((int) $itemRaw->acordoitemsequencial)
                ->setCodigoPcMater((int) $itemRaw->codigoitem)
                ->setQuantidade((float)$itemRaw->quantidade)
                ->setQuantidadeAditada((float)$itemRaw->quantiaditada)
                ->setValorUnitario((float) $itemRaw->valorunitario)
                ->setValorTotal((float) $itemRaw->valor);

            $dataInicio = !empty($itemRaw->dtexecucaoinicio)
                ? DateTime::createFromFormat($this->getFormatDate($itemRaw->dtexecucaoinicio),$itemRaw->dtexecucaoinicio)
                : null;


            $dataFim = !empty($itemRaw->dtexecucaofim)
                ? DateTime::createFromFormat($this->getFormatDate($itemRaw->dtexecucaofim), $itemRaw->dtexecucaofim)
                : null;

            $item->setInicioExecucao($dataInicio)
                 ->setFimExecucao($dataFim);

            if (count($itemRaw->dotacoes) > 0 ) {
                $itemDotacaoFactory = new ItemDotacaoFactory();
                $itemDotacoes = $itemDotacaoFactory->createlistByStdLegacy($itemRaw->dotacoes);
                $item->setItemDotacoes($itemDotacoes);
            }

            if (!empty($itemRaw->unidade)) {
                $item->setUnidade((int)$itemRaw->unidade);
            }

            if (!empty($itemRaw->codigoelemento)) {
                $servicoQuantidade = $itemRaw->controlaServico === 't' ? true : false;
                $item->setCodigoElemento($itemRaw->codigoelemento)
                    ->setOrdem($key + 1)
                    ->setServicoQuantidade($servicoQuantidade);
            }

            $listaItens[] = $item;
        }

        return $listaItens;
    }

    private function getFormatDate(string $date): string
    {
       if (strpos( $date, '/') === false) {
        return 'Y-m-d';
       }
       return 'd/m/Y';
    }
}
