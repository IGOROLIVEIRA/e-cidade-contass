<?php

namespace App\Repositories\Contracts\Patrimonial;

use App\Models\Acordo;

interface AcordoRepositoryInterface
{
    public function getAcordo(int $codigoAcordo, $fields = ['*']): Acordo;
}
