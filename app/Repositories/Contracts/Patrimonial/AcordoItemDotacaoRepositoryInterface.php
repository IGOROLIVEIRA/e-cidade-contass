<?php
namespace App\Repositories\Contracts\Patrimonial;

use App\Domain\Patrimonial\Aditamento\ItemDotacao;
use App\Models\AcordoItemDotacao;

interface AcordoItemDotacaoRepositoryInterface
{
    /**
     *
     * @param integer $codigoItem
     * @param array $dados
     * @return boolean
     */
    public function updateByAcordoItem(int $codigoItem, array $dados): bool;

    /**
     *
     * @param integer $acordoItem
     * @return integer
     */
    public function getQtdDotacaoByAcordoItem(int $acordoItem): int;

     /**
     *
     * @param ItemDotacao $itemDotacao
     * @param integer $acordoItemSequencial
     * @return AcordoItemDotacao|null
     */
    public function saveByDomainAditamento(ItemDotacao $itemDotacao, int $acordoItemSequencial): ?AcordoItemDotacao;
}
