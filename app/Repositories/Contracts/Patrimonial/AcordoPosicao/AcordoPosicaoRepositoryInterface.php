<?php

namespace App\Repositories\Contracts\Patrimonial\AcordoPosicao;

interface AcordoPosicaoRepositoryInterface
{
    /**
     *
     * @param integer $ac26Acordo
     * @return void
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo);
}
