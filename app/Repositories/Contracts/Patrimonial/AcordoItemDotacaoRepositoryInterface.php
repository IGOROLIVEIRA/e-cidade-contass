<?php
namespace App\Repositories\Contracts\Patrimonial;

interface AcordoItemDotacaoRepositoryInterface
{
    public function updateByAcordoItem(int $codigoItem, array $dados): bool;
    public function getQtdDotacaoByAcordoItem(int $acordoItem): int;
}
