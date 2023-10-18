<?php

namespace App\Repositories\Contracts\Patrimonial;

use App\Models\AcordoPosicao;

interface AcordoPosicaoRepositoryInterface
{
    /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo): AcordoPosicao;
}
