<?php
namespace App\Repositories\Contracts\Patrimonial;

use App\Domain\Patrimonial\Aditamento\ItemDotacao;

interface AcordoItemDotacaoRepositoryInterface
{
    public function updateByAcordoItem(int $codigoItem, array $dados): bool;
    public function getQtdDotacaoByAcordoItem(int $acordoItem): int;
    public function saveByDomainAditamento(ItemDotacao $itemDotacao, int $acordoItemSequencial): bool;
}
