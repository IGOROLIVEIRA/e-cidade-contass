<?php

namespace App\Services\Contracts\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;

interface ValidaDataAssinaturaCommandInterface
{
    /**
     *
     * @param Aditamento $aditamento
     * @return void
     */
    public function execute(Aditamento $aditamento): void;
}
