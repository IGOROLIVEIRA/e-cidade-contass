<?php

namespace App\Services\Contracts\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;

interface UpdateAditamentoCommandInterface
{
    public function execute(Aditamento $aditamento): bool;
}
