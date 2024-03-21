<?php

namespace App\Repositories\Contracts\Patrimonial;

use App\Models\AcordoItemPeriodo;

interface AcordoItemPeriodoRepositoryInterface
{
    /**
     *
     * @param integer $codigoItem
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigoItem, array $dados): bool;

    /**
     *
     * @param array $dados
     * @return AcordoItemPeriodo|null
     */
    public function insert(array $dados): ?AcordoItemPeriodo;
}
