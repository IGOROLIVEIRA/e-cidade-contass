<?php

namespace App\Services\Contracts\Patrimonial\Aditamento;

use stdClass;

interface AditamentoServiceInterface
{
    /**
     *
     * @param integer $ac16Sequencial
     * @return array
     */
    public function getDadosAditamento(int $ac16Sequencial): array;

    public function updateAditamento(stdClass $aditamentoRaw);
}
