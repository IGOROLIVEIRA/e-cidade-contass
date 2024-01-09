<?php

namespace App\Repositories\Contracts\Patrimonial;

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
     * @param array $dados
     * @return boolean
     */
    public function insert(array $dados): bool;
}
