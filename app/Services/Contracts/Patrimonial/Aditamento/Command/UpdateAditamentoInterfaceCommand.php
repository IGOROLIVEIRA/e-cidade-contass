<?php

namespace App\Services\Contracts\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;

interface UpdateAditamentoInterfaceCommand
{
    public function execute(Aditamento $aditamento);
}
