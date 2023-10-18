<?php

namespace App\Services\Contracts\Patrimonial\Aditamento;

use App\Services\Patrimonial\Aditamento\AditamentoSerializeService;

interface AditamentoServiceInterface
{
    /**
     *
     * @param integer $ac16Sequencial
     * @return AditamentoSerializeService
     */
    public function getDadosAditamento(int $ac16Sequencial): AditamentoSerializeService;
}
