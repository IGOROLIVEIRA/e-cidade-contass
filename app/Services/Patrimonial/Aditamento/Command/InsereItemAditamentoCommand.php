<?php

namespace App\Services\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Item;
use App\Domain\Patrimonial\Aditamento\ItemDotacao;
use App\Repositories\Contracts\Patrimonial\AcordoItemDotacaoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoItemPeriodoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoItemRepositoryInterface;
use App\Repositories\Patrimonial\AcordoItemDotacaoRepository;
use App\Repositories\Patrimonial\AcordoItemPeriodoRepository;
use App\Repositories\Patrimonial\AcordoItemRepository;
use App\Services\DTO\Patrimonial\InsertItemDto;

class InsereItemAditamentoCommand
{

    /**
     * @var AcordoItemRepositoryInterface
     */
    private AcordoItemRepositoryInterface $acordoItemRepository;

    /**
     * @var AcordoItemPeriodoRepositoryInterface
     */
    private AcordoItemPeriodoRepositoryInterface $acordItemPeriodRepository;

    /**
     * @var AcordoItemDotacaoRepositoryInterface
     */
    private AcordoItemDotacaoRepositoryInterface $acordoItemDotacaoRepository;

    /**
     * @var InsertItemDto
     */
    private InsertItemDto $dto;

    public function __construct(
        AcordoItemRepository $acordoItemRepository,
        AcordoItemPeriodoRepository $acordoItemPeriodoRepository,
        AcordoItemDotacaoRepository $acordoItemDotacaoRepository,
        InsertItemDto $dto
    ) {
        $this->acordoItemRepository = $acordoItemRepository;
        $this->acordItemPeriodRepository = $acordoItemPeriodoRepository;
        $this->acordoItemDotacaoRepository = $acordoItemDotacaoRepository;
        $this->dto = $dto;
    }

    /**
     *
     * @return void
     */
    public function execute()
    {
         $item = $this->dto->getItem();

        $acordoItem = $this->acordoItemRepository
            ->saveByItemAditamento(
                $item,
                $this->dto->getSequencialAcordoPosicao()
            );

        if (empty($acordoItem)) {
            throw new \Exception("Erro ao inserir acordo item {$item->getCodigoPcMater()}");
        }

        /** @var ItemDotacao $itemDotacao */
        foreach ($item->getItemDotacoes() as $itemDotacao) {
            $resultItemDotacao = $this->acordoItemDotacaoRepository->saveByDomainAditamento($itemDotacao, $acordoItem->ac20_sequencial);
            if (!$resultItemDotacao) {
                throw new \Exception("Erro ao inserir item dotação {$itemDotacao->getCodigoDotacao()} no item {$item->getCodigoPcMater()}");
            }
        }

        $resultItemPeriodo = $this->acordItemPeriodRepository->insert(
            [
                'ac41_acordoitem'    => $acordoItem->ac20_sequencial,
                'ac41_datainicial'   => $item->getInicioExecucao()->format('Y-m-d'),
                'ac41_datafinal'     => $item->getFimExecucao()->format('Y-m-d'),
                'ac41_acordoposicao' => $this->dto->getSequencialAcordoPosicao()
            ]
        );

        if (!$resultItemPeriodo) {
            throw new \Exception("Erro ao inserir acordo periodo no item {$item->getCodigoPcMater()}");
        }
    }
}
