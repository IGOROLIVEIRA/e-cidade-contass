<?php

namespace App\Repositories\Contracts\Patrimonial;

interface AcordoItemPeriodoRepositoryInterface
{
    public function update(int $codigoItem, array $data): bool;
}
