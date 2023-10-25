<?php

namespace App\Repositories\Contracts\Patrimonial;

interface AcordoItemRepositoryInterface
{
    /**
     *
     * @param integer $codigo
     * @param array $data
     * @return void
     */
    public function update(int $codigo, array $data): bool;
}
